<template>
  <div class="p-5 xl:px-0">
    <transition name="fade" mode="out-in"
      >sss
      <FlashMessage message="loading..." v-if="loading" key="loading" />
      <div v-else>
        <TaskForm />
        <div class="inline-flex items-center space-x-2" v-if="task.id > 0">
          <a
            class="badge badge-warning"
            :href="'/task-list/' + task.task_list_id"
          >
            <span class="text-gray-600">Task List</span>
          </a>
        </div>
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
import store from "@/store/index";
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
    const id = to.params.id;
    console.log("taskId=", id);
    if (id > 0) {
      store.dispatch("task/getTask", id).then(() => {
        // console.log("getTask.task=", this.task);
        // console.log("getTask.tasks=", this.tasks);
        to.params.page = id;
        next();
      });
    } else {
      next();
    }
  },
};
</script>
