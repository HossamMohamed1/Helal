<template>
  <div class="d-flex flex-column flex-grow-1">
    <div class="d-flex align-center py-3">
      <div>
        <div class="display-1">{{ $t('menu.mailTemplate') }}</div>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0 py-2"></v-breadcrumbs>
      </div>
    </div>

    <v-row>
      <v-col cols="12">
        <v-card class="pa-2">
          <div class="title mb-2">
            {{ $t('general.mailTemplateContent') }}
          </div>
          <v-form>
            <div class="mb-4">
              <label class="text--primary font-weight-medium text-darken mb-1 d-block">{{ $t('email.generalMail') }}</label>
              <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
            </div>
            <div class="mb-4">
              <label class="text--primary font-weight-medium text-darken mb-1 d-block">{{ $t('email.newUserMail') }}</label>
              <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
            </div>
            <div class="mb-4">
              <label class="text--primary font-weight-medium text-darken mb-1 d-block">{{ $t('email.mailWhenUserUpdate') }}</label>
              <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
            </div>
            <div class="mb-3">
              <label class="text--primary font-weight-medium text-darken mb-1 d-block">{{ $t('email.mailNotificationForms') }}</label>
              <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
            </div>
            <div class="d-flex mt-3">
              <v-btn color="primary">{{ $t('general.save') }}</v-btn>
            </div>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>

import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
  components: {
  },
  data() {
    return {
      isLoading: false,
      breadcrumbs: [{
        text: this.$t('menu.settings'),
        disabled: false,
        href: '#'
      }, {
        text: this.$t('menu.mailTemplate')
      }],
      editor: ClassicEditor,
      editorData: '<p>مرحبا بالمستخدم <br>[[المحتوى]]</p>',
      editorConfig: {
        // The configuration of the editor.
      }
      // breadcrumbs: [{
      //   text: 'Roles',
      //   to: '/roles/list',
      //   exact: true
      // }, {
      //   text: 'View Role'
      // }]
    }
  },
  watch: {
    selectedRoles(val) {

    }
  },
  methods: {
    searchRole() {
    },
    open() {
    }
  }
}
</script>

<style >
.ck-editor__editable.ck-content{
  min-height: 200px;
}
</style>
