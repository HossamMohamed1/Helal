<?php

namespace App\Services\Report;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use JsonException;

class QuestionReport extends BaseReport
{
    public array $queries = [];

    public function __construct()
    {
        $this->mainTable = 'question_logs';
    }

    /**
     * @param $filter
     * @return array
     * @throws Exception
     */
    public function report($filter): array
    {
        try {
            $this->prepare($filter);

            return $this->getReport($filter);

        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $filter
     */
    public function prepare($filter): void
    {
        $filter['format_date'] = $this->guessDateFormat($filter['start'], $filter['end']);

        foreach ($filter['type_list'] as $type => $columns) {
            $func_name = "prepare{$type}Query";
            if (method_exists($this, $func_name)) {
                $queries[$type] = $this->$func_name($filter, $filter['type_list'][$type] ?? []);
            }
        }

        $this->queries = $queries ?? [];
    }

    /**
     * @throws JsonException
     */
    public function getReport($filter): array
    {
        $result = [];
        foreach ($this->queries as $key => $query) {
            $filter['column'] = "$this->mainTable.created_at";
            $query = $this->handleDateFilter($query, $filter);

            $data = json_decode($query->groupBy($filter['groupBy'])
                ->get()
                ->mapWithKeys(function ($item) use ($filter) {
                    return [$item->{$filter['groupBy']} => $item];
                }), true, 512, JSON_THROW_ON_ERROR);

            $columns = $filter['type_list'][$key];

            $result[$key] = collect($data)->map(function ($item) use ($columns) {
                foreach ($columns as $column) {
                    if (!isset($item[$column])) {
                        $item[$column] = 0;
                    }
                }
                return $item;
            })->toArray();
        }

        return $result;
    }

    /**
     * @param $filter
     * @param $listKeys
     * @return Builder
     */
    private function prepareCompareQuestionAnswerQuery($filter, $listKeys): Builder
    {
        return DB::table($this->mainTable)
            ->select(
                DB::raw("(DATE_FORMAT($this->mainTable.created_at, '{$filter['format_date']}')) as {$filter['groupBy']}"),
                DB::raw("COUNT($this->mainTable.id) as questions"),
                DB::raw("SUM($this->mainTable.answers_count) as answers")
            );
    }

    /**
     * @param $filter
     * @param $listKeys
     * @return Builder
     */
    private function prepareQuestionsTimeQuery($filter, $listKeys): Builder
    {
        return DB::table($this->mainTable)
            ->select(
                DB::raw("(DATE_FORMAT($this->mainTable.created_at, '%h:00 %p')) as {$filter['groupBy']}"),
                DB::raw("COUNT(id) as questions"),
            );
    }


    /**
     * @param $filter
     * @param $listKeys
     * @return Builder
     */
    private function prepareCompareQuestionsQuery($filter, $listKeys): Builder
    {
        return DB::table($this->mainTable)
            ->select(
                DB::raw("(DATE_FORMAT($this->mainTable.created_at, '{$filter['format_date']}')) as {$filter['groupBy']}"),
                DB::raw("COUNT(CASE WHEN answers_count != 0 then 1 ELSE NULL END) as questions_answer"),
                DB::raw("COUNT(CASE WHEN answers_count = 0 then 1 ELSE NULL END) as questions_no_answer"),
            );
    }

    /**
     * @param $filter
     * @param $listKeys
     * @return Builder
     */
    private function prepareQuestionNoAnswerQuery($filter, $listKeys): Builder
    {
        $listKey = \Arr::first($listKeys);

        return DB::table($this->mainTable)
            ->select(
                DB::raw("(DATE_FORMAT($this->mainTable.created_at, '{$filter['format_date']}')) as {$filter['groupBy']}"),
                DB::raw("COUNT($this->mainTable.id) as $listKey")
            )->where("$this->mainTable.answers_count", '=', 0);
    }

    /**
     * @param $filter
     * @param $listKeys
     * @return Builder
     */
    private function prepareTotalQuestionQuery($filter, $listKeys): Builder
    {
        $listKey = \Arr::first($listKeys);

        return DB::table($this->mainTable)
            ->select(
                DB::raw("(DATE_FORMAT($this->mainTable.created_at, '{$filter['format_date']}')) as {$filter['groupBy']}"),
                DB::raw("COUNT($this->mainTable . id) as $listKey")
            );
    }

    /**
     * @param $filter
     * @param $listKeys
     * @return Builder
     */
    private function prepareTotalAnswerQuery($filter, $listKeys): Builder
    {
        $listKey = \Arr::first($listKeys);

        return DB::table($this->mainTable)
            ->select(
                DB::raw("(DATE_FORMAT($this->mainTable.created_at, '{$filter['format_date']}')) as {$filter['groupBy']}"),
                DB::raw("SUM($this->mainTable . answers_count) as $listKey")
            );
    }
}
