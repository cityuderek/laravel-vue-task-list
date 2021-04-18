<template>
  <div class="p-5 xl:px-0">
    <transition name="fade" mode="out-in">
      <FlashMessage
        message="loading..."
        v-if="loading && !taskLists.length"
        key="loading"
      />
      <div v-else class="mt-5">
        <ul class="mt-5">
          <li
            v-for="taskList in taskLists"
            :key="taskList.id"
            class="flex items-center justify-between py-2 border-b"
          >
            <div class="inline-flex items-center space-x-2">
              <a
                class="badge badge-warning"
                :href="'/task-list/' + taskList.id"
              >
                <span class="text-gray-600">{{ taskList.title }}</span>
              </a>
            </div>
            <div class="inline-flex items-center space-x-2">
              <a
                class="badge badge-warning"
                :href="'/task-list/' + taskList.id"
              >
                <span class="text-gray-600">{{ taskList.description }}</span>
              </a>
            </div>
          </li>
        </ul>

        <div class="flex mb-2">
          <BaseBtn @click="createTaskList" text="Create Task List" />
        </div>
      </div>
    </transition>
    <transition name="fade">
      <FlashMessage :error="error" v-if="error" key="error" />
    </transition>
    <transition name="fade">
      <BasePagination
        path="taskLists"
        :meta="meta"
        :links="links"
        action="taskList/paginateTaskLists"
        v-if="meta && meta.last_page > 1"
      />
    </transition>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import store from "@/store/index";
import BaseBtn from "@/components/BaseBtn";
import FlashMessage from "@/components/FlashMessage";
import BasePagination from "@/components/BasePagination";

export default {
  name: "TaskListsView",
  components: { FlashMessage, BasePagination, BaseBtn },
  computed: {
    ...mapGetters("taskList", [
      "loading",
      "error",
      "taskLists",
      "meta",
      "links",
    ]),
  },
  methods: {
    async createTaskList() {
      window.location = "/task-list/0";
    },
  },
  beforeRouteEnter(to, from, next) {
    const currentPage = parseInt(to.query.page) || 1;
    store.dispatch("taskList/getTaskLists", currentPage).then(() => {
      to.params.page = currentPage;
      next();
    });
  },
};
</script>
