<template>
  <div>
    <transition name="fade" mode="out-in">
      <FlashMessage
        message="loading..."
        v-if="loading && !taskLists.length"
        key="loading"
      />
      <ul v-else>
        <li
          v-for="taskList in taskLists"
          :key="taskList.id"
          class="flex py-2 space-x-2 border-b"
        >
          <div>
            <div class="flex space-x-2">
              <span class="text-gray-400">{{ taskList.createdAt }}</span>
            </div>
            <div class="text-gray-600">{{ taskList.title }}</div>
          </div>
        </li>
      </ul>
    </transition>
    <transition name="fade">
      <FlashMessage :error="error" v-if="error" key="error" />
    </transition>
    <transition name="fade">
      <BasePagination
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
import FlashMessage from "@/components/FlashMessage";
import BasePagination from "@/components/BasePagination";

export default {
  name: "TaskLists",
  components: { FlashMessage, BasePagination },
  computed: {
    ...mapGetters("taskList", [
      "loading",
      "error",
      "taskLists",
      "meta",
      "links",
    ]),
  },
  created() {
    const currentPage = 1;
    this.$store.dispatch("taskList/getTaskLists", currentPage);
  },
};
</script>
