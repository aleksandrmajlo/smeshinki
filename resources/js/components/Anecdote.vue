<template>
  <div class="card" v-cloak>
    <div class="card-body">
      <h5 class="card-title text-center">{{ title }}</h5>
      <div class="card-text text-left">
        <span v-html="description"></span>
      </div>
    </div>
  </div>
</template>

<script>
import { eventBus } from "../app";
export default {
  name: "Anecdote",
  data() {
    return {
      title: "",
      description: "",
      ids: [],
    };
  },
  created() {
    this.getAnectod();
    eventBus.$on("anecdoteChange", () => {
      this.getAnectod();
    });
  },
  methods: {
    getAnectod() {
      axios
        .post("/getAnecdote", {
          ids: this.ids,
        })
        .then((res) => {
          this.title = res.data.anecdote.title;
          this.description = res.data.anecdote.description;
          if (res.data.new_arr) {
            this.ids = [];
            this.ids.push(res.data.anecdote.id);
          } else {
            this.ids.push(res.data.anecdote.id);
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>

