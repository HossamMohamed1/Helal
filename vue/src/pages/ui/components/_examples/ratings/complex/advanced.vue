<template>
  <v-card class="mx-auto overflow-hidden" style="max-width: 600px">
    <v-row>
      <v-col class="d-flex" cols="6">
        <v-img
          :src="require('@/assets/images/images/demo/cards/cooking.png')"
        ></v-img>
      </v-col>
      <v-col cols="6">
        <v-container class="pa-0 pl-2" style="margin: -4px 0">
          <v-row>
            <v-col class="d-flex" cols="7">
              <v-img
                :src="require('@/assets/images/images/demo/cards/desert.jpg')"
              ></v-img>
            </v-col>
            <v-col class="d-flex" cols="5">
              <v-img
                :src="require('@/assets/images/images/demo/cards/foster.jpg')"
              ></v-img>
            </v-col>
            <v-col class="d-flex" cols="5">
              <v-img
                :src="require('@/assets/images/images/demo/cards/house.jpg')"
              ></v-img>
            </v-col>
            <v-col class="d-flex" cols="7">
              <v-img
                :src="require('@/assets/images/images/demo/cards/road.jpg')"
              ></v-img>
            </v-col>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
    <v-card-title class="align-start">
      <div>
        <span class="headline">Mega Mix</span>
        <div class="grey--text font-weight-light">Let's go</div>
      </div>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" width="400">
        <template v-slot:activator="{ on }">
          <v-icon v-on="on"> mdi-share-variant </v-icon>
        </template>
        <v-card>
          <v-card-title>
            <span class="title font-weight-bold">Share</span>
            <v-spacer></v-spacer>
            <v-btn class="mx-0" icon @click="dialog = false">
              <v-icon>mdi-close-circle-outline</v-icon>
            </v-btn>
          </v-card-title>
          <v-list>
            <v-list-item @click="">
              <v-list-item-action>
                <v-icon color="indigo">mdi-facebook</v-icon>
              </v-list-item-action>
              <v-card-title>Facebook</v-card-title>
            </v-list-item>
            <v-list-item @click="">
              <v-list-item-action>
                <v-icon color="cyan">mdi-twitter</v-icon>
              </v-list-item-action>
              <v-card-title>Twitter</v-card-title>
            </v-list-item>
            <v-list-item @click="">
              <v-list-item-action>
                <v-icon>mdi-email</v-icon>
              </v-list-item-action>
              <v-card-title>Email</v-card-title>
            </v-list-item>
          </v-list>
          <v-text-field
            ref="link"
            :label="copied ? 'Link copied' : 'Click to copy link'"
            class="pa-4"
            readonly
            value="https://g.co/kgs/nkrK43"
            @click="copy"
          ></v-text-field>
        </v-card>
      </v-dialog>
    </v-card-title>
    <v-divider></v-divider>
    <v-card-actions>
      <span class="pl-2 grey--text text--darken-2 font-weight-light caption"
        >16,544 reviews</span
      >
      <v-spacer></v-spacer>
      <v-rating v-model="rating" length="10" readonly>
        <template v-slot:item="props">
          <v-icon
            :color="props.isFilled ? 'purple darken-4' : ''"
            v-text="`mdi-numeric-${props.index}-box`"
          ></v-icon>
        </template>
      </v-rating>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    copied: false,
    dialog: false,
    rating: 10,
  }),

  methods: {
    copy() {
      const markup = this.$refs.link;

      markup.focus();
      document.execCommand("selectAll", false, null);
      this.copied = document.execCommand("copy");
    },
  },
};
</script>
