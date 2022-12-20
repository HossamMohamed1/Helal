<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      max-width="500"
    >
      <v-card>
        <v-card-title class="text-h5">
          {{ $t('general.confirmationLog') }}
        </v-card-title>

        <v-card-text>
          <v-row>
            <v-col cols="12">
              <v-textarea
                :label="$t('general.note')"
                value=""
              ></v-textarea>

            </v-col>
            <v-col cols="12">
              <v-file-input
                :label="$t('general.uploadFile')"
              ></v-file-input>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn
            color="green darken-1"
            text
            @click="dialog = false"
          >
            {{ $t('general.save') }}
          </v-btn>

          <v-btn
            color="green darken-1"
            text
            @click="dialog = false"
          >
            {{ $t('general.cancel') }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  props: {
    value: Boolean
  },
  computed: {
    dialog: {
      get () {
        return this.value
      },
      set (value) {
        this.$emit('input', value)
      }
    }
  }
}
</script>
