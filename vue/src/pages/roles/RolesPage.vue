<template>
  <div class="d-flex flex-column flex-grow-1">
    <div class="d-flex align-center py-3">
      <div>
        <div class="display-1">{{ $t('users.rolesList') }}</div>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
      </div>
      <v-spacer></v-spacer>
      <v-btn color="primary" to="/roles/create">
        {{ $t('users.createRole') }}
      </v-btn>
    </div>

    <!-- roles list -->
    <v-row dense class="">
      <div class="col-md-4 mb-2">
        <v-card
          class="mx-auto"
        >
          <v-card-text class="px-3 pt-3">
            <div class="title font-weight-bold text--primary">{{ $t('texts.administrator') }}</div>
            <p>{{ $t('texts.totalUsersWithThisRole') }}: 5</p>
            <div class="d-flex flex-column">
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.AllAdminControls') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewAndEditFinancialSummaries') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.EnabledBulkReports') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewAndEditPayouts') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewAndEditDisputes') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1 text--primary"></span>
                <em color="deep-purple accent-4">{{ $t('texts.and7more') }}</em>
              </div>
            </div>
          </v-card-text>
          <v-card-actions class="px-3 pb-3">
            <v-btn
              color="dark"
              to="/roles/view"
            >
              {{ $t('users.viewRole') }}
            </v-btn>
            <v-btn
              color="dark"
              to="/roles/edit"
            >
              {{ $t('users.editRole') }}
            </v-btn>
          </v-card-actions>
        </v-card>

      </div>
      <div class="col-md-4 mb-2">
        <v-card
          class="mx-auto"
        >
          <v-card-text class="px-3 pt-3">
            <div class="title font-weight-bold text--primary">{{ $t('texts.developer') }}</div>
            <p>{{ $t('texts.totalUsersWithThisRole') }}: 14</p>
            <div class="d-flex flex-column">
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.SomeAdminControls') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewFinancialSummariesOnly') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewAndEditAPIControls') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewAndEditDisputes') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.SomeAdminControls') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1 text--primary"></span>
                <em color="deep-purple accent-4">{{ $t('texts.and3more') }}...</em>
              </div>
            </div>
          </v-card-text>
          <v-card-actions class="px-3 pb-3">
            <v-btn
              color="dark"
              to="/roles/view"
            >
              {{ $t('users.viewRole') }}
            </v-btn>
            <v-btn
              color="dark"
              to="/roles/edit"
            >
              {{ $t('users.editRole') }}
            </v-btn>
          </v-card-actions>
        </v-card>

      </div>
      <div class="col-md-4 mb-2">
        <v-card
          class="mx-auto"
        >
          <v-card-text class="px-3 pt-3">
            <div class="title font-weight-bold text--primary">{{ $t('texts.analyst') }}</div>
            <p>{{ $t('texts.totalUsersWithThisRole') }}: 4</p>
            <div class="d-flex flex-column">
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewAndEditPayouts') }}
              </div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ResponseToCustomerFeedback') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewPayoutsOnly') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewDisputesOnly') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewAndEditDisputes') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1 text--primary"></span>
                <em color="deep-purple accent-4">{{ $t('texts.and3more') }}...</em>
              </div>
            </div>
          </v-card-text>
          <v-card-actions class="px-3 pb-3">
            <v-btn
              color="dark"
              to="/roles/view"
            >
              {{ $t('users.viewRole') }}
            </v-btn>
            <v-btn
              color="dark"
              to="/roles/edit"
            >
              {{ $t('users.editRole') }}
            </v-btn>
          </v-card-actions>
        </v-card>

      </div>
      <div class="col-md-4 mb-2">
        <v-card
          class="mx-auto"
        >
          <v-card-text class="px-3 pt-3">
            <div class="title font-weight-bold text--primary">{{ $t('texts.user') }}</div>
            <p>{{ $t('texts.totalUsersWithThisRole') }}: 25</p>
            <div class="d-flex flex-column">
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.NoAdminControls') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewFinancialSummariesOnly') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewPayoutsOnly') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewDisputesOnly') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ResponseToCustomerFeedback') }}</div>
            </div>
          </v-card-text>
          <v-card-actions class="px-3 pb-3">
            <v-btn
              color="dark"
              to="/roles/view"
            >
              {{ $t('users.viewRole') }}
            </v-btn>
            <v-btn
              color="dark"
              to="/roles/edit"
            >
              {{ $t('users.editRole') }}
            </v-btn>
          </v-card-actions>
        </v-card>

      </div>
      <div class="col-md-4 mb-2">
        <v-card
          class="mx-auto"
        >
          <v-card-text class="px-3 pt-3">
            <div class="title font-weight-bold text--primary">{{ $t('texts.trial') }}</div>
            <p>{{ $t('texts.totalUsersWithThisRole') }}: 523</p>
            <div class="d-flex flex-column">
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.NoAdminControls') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewFinancialSummariesOnly') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.EnabledBulkReports') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ViewDisputesOnly') }}</div>
              <div class="d-flex align-center mb-1 text--primary">
                <span class="bullet bg-primary mx-1"></span>{{ $t('texts.ResponseToCustomerFeedback') }}</div>
            </div>
          </v-card-text>
          <v-card-actions class="px-3 pb-3">
            <v-btn
              color="dark"
              to="/roles/view"
            >
              {{ $t('users.viewRole') }}
            </v-btn>
            <v-btn
              color="dark"
              to="/roles/edit"
            >
              {{ $t('users.editRole') }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </div>
    </v-row>

  </div>
</template>

<script>

export default {
  components: {
  },
  data() {
    return {
      isLoading: false,
      breadcrumbs: [{
        text: this.$t('menu.usersManagement'),
        disabled: false,
        href: '#'
      }, {
        text: this.$t('users.rolesList')
      }],

      roles
    }
  },
  watch: {

  },
  methods: {
    open() {}
  }
}
</script>

<style lang="scss" scoped>

</style>
