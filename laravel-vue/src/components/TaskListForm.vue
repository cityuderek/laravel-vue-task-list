<template>
  <form @submit.prevent="updateTask">
    <h2>Task List:</h2>
    ID: {{ id }}
    <BaseInput
      type="message"
      label="Title"
      name="title"
      v-model="title"
      class="mb-4"
    />
    <BaseInput
      type="message"
      label="Description"
      name="description"
      v-model="description"
      class="mb-4"
    />
    <div class="flex justify-end mb-2">
      <BaseBtn type="submit" :text="id > 0 ? 'Save' : 'Create'" />
    </div>
    <FlashMessage :error="error" />
  </form>
</template>

<script>
import { mapGetters } from "vuex";
import { getError } from "@/utils/helpers";
import BaseBtn from "@/components/BaseBtn";
import BaseInput from "@/components/BaseInput";
import FlashMessage from "@/components/FlashMessage";

export default {
  name: "TaskForm",
  components: {
    BaseBtn,
    BaseInput,
    FlashMessage,
  },
  data() {
    return {
      id: null,
      title: null,
      description: null,
      error: null,
    };
  },
  computed: {
    ...mapGetters("taskList", ["taskList"]),
  },
  methods: {
    async updateTask() {
      try {
        let payload = {
          title: this.title,
          description: this.description,
        };
        this.error = null;

        if (this.id > 0) {
          payload.id = this.id;
          await this.$store.dispatch("taskList/updateTaskList", payload);
        } else {
          await this.$store.dispatch("taskList/createTaskList", payload);
        }
      } catch (error) {
        this.error = getError(error);
      }
    },
  },
  mounted() {
    this.id = this.taskList.id;
    this.title = this.taskList.title;
    this.description = this.taskList.description;
  },
};
</script>
