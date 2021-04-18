<template>
  <div class="p-5 xl:px-0">
    <transition name="fade" mode="out-in"
      >sss
      <FlashMessage
        message="loading..."
        v-if="loading && !task.id"
        key="loading"
      />
      <div v-else>
        <TaskForm />
      </div>
    </transition>
    <transition name="fade">
      <FlashMessage :error="error" v-if="error" key="error" />
    </transition>
    <transition name="fade">
      <BasePagination
        path="tasks"
        :meta="meta"
        :links="links"
        action="task/paginateTasks"
        v-if="meta && meta.last_page > 1"
      />
    </transition>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import FlashMessage from "@/components/FlashMessage";
import BasePagination from "@/components/BasePagination";
import TaskForm from "@/components/TaskForm";

export default {
  name: "TaskView",
  components: { FlashMessage, BasePagination, TaskForm },
  computed: {
    ...mapGetters("task", ["loading", "error", "task", "meta", "links"]),
  },
  beforeRouteEnter(to, from, next) {
    const task_list_id = to.params.task_list_id;
    console.log("task_list_id=", task_list_id);
    next();
  },
};
</script>
