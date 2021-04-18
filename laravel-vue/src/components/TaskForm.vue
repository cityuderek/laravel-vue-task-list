<template>
  <form @submit.prevent="updateTask">
    <h2>Task:</h2>
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
    Is Done: {{ is_done }}
    <div class="flex mb-2" v-if="id > 0">
      <BaseBtn
        @click="toggleDone"
        :text="is_done ? 'Set Not Done' : 'Set Done'"
      />
    </div>

    <div class="flex mb-2" v-if="id > 0">
      <BaseBtn @click="deleteTask" text="Delete" />
    </div>
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
    console.log("data");
    return {
      id: null,
      task_list_id: null,
      title: null,
      description: null,
      is_done: false,
      error: null,
    };
  },
  computed: {
    ...mapGetters("task", ["task"]),
  },
  methods: {
    async updateTask() {
      const task_list_id = this.$route.params.task_list_id;
      // console.log("updateTask.task_list_id=", task_list_id);

      try {
        const payload = {
          title: this.title,
          description: this.description,
          is_done: this.is_done,
        };
        this.error = null;

        if (this.id > 0) {
          payload.id = this.id;
          await this.$store.dispatch("task/updateTask", payload);
        } else {
          payload.task_list_id = task_list_id;
          // console.log(`payload=`, payload);
          await this.$store.dispatch("task/createTask", payload);
        }
      } catch (error) {
        this.error = getError(error);
      }
    },
    async toggleDone(e) {
      e.preventDefault();
      try {
        const payload = {
          id: this.id,
          is_done: !this.is_done,
        };
        this.error = null;
        await this.$store.dispatch("task/setDone", payload);
        // this.title = null;
      } catch (error) {
        this.error = getError(error);
      }
      return false;
    },
    async deleteTask(e) {
      e.preventDefault();
      try {
        if (confirm("Do you really want to delete?")) {
          const payload = {
            id: this.id,
          };
          this.error = null;
          await this.$store.dispatch("task/deleteTask", payload);
        }
      } catch (error) {
        this.error = getError(error);
      }
    },
  },
  mounted() {
    this.id = this.task.id;
    this.title = this.task.title;
    this.description = this.task.description;
    this.is_done = !!this.task.is_done;
    console.log("mounted.task_list_id=", this.task_list_id);
  },
  beforeRouteEnter(to, from, next) {
    const task_list_id = to.params.task_list_id;
    this.task_list_id = task_list_id;
    console.log("beforeRouteEnter.task_list_id=", this.task_list_id);
    next();
  },
};
</script>
