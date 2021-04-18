<template>
  <div class="p-5 xl:px-0">
    <transition name="fade" mode="out-in">
      <FlashMessage
        message="loading..."
        v-if="loading || !taskList"
        key="loading"
      />
      <div v-else>
        <TaskListForm />
        <div v-if="taskList.id > 0">
          <div class="mt-5">
            <span class="text-gray-600">ID: {{ taskList.id }}</span>
          </div>
          <div class="mt-5">
            <span class="text-gray-600"
              >Task count: {{ taskList.tasks.length }}</span
            >
          </div>
          <div class="mt-5">
            <h3>Tasks:</h3>
          </div>
          <div class="flex mb-2">
            <BaseBtn @click="createTask" text="Create Task" />
          </div>
          <ul class="mt-5">
            <li
              v-for="task in taskList.tasks"
              :key="task.id"
              class="flex items-center justify-between py-2 border-b"
            >
              <div class="inline-flex items-center space-x-2">
                <a class="badge badge-warning" :href="'/task/' + task.id">
                  <span class="text-gray-600">{{ task.title }}</span>
                </a>
              </div>
              <div class="inline-flex items-center space-x-2">
                <a class="badge badge-warning" :href="'/task/' + task.id">
                  <span class="text-gray-600">{{ task.description }}</span>
                </a>
              </div>
            </li>
          </ul>
          <h2>Uncompleted Task Chart:</h2>
          <TaskCountLineChart :data="taskListStat" />
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
import TaskListForm from "@/components/TaskListForm";
import TaskCountLineChart from "@/components/TaskCountLineChart";

export default {
  name: "TaskListView",
  components: {
    FlashMessage,
    BasePagination,
    TaskListForm,
    BaseBtn,
    TaskCountLineChart,
  },
  data() {
    console.log("data");
    return {
      task_list_id: null,
      uncompletedTaskCounts: [],
      datacollection: null,
      chartData: {
        Books: 24,
        Magazine: 30,
        Newspapers: 10,
      },
    };
  },
  computed: {
    ...mapGetters("taskList", [
      "loading",
      "error",
      "taskList",
      "taskListStat",
      "meta",
      "links",
    ]),
  },
  created() {
    this.refreshStat();
    this.timer = setInterval(this.refreshStat, 60000);
  },
  methods: {
    async createTask() {
      window.location = "/task/create/" + this.taskList.id;
    },
    async refreshStat() {
      const task_list_id = this.$route.params.id;
      // console.log(`refreshStat; task_list_id=${task_list_id}, dt=${new Date()}`, this.taskListStat);
      if (task_list_id) {
        store.dispatch("taskList/getStat", task_list_id);
      }
    },
    getRandomInt() {
      return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
    },
  },
  beforeRouteEnter(to, from, next) {
    const task_list_id = to.params.id;
    // console.log("beforeRouteEnter taskListId=", task_list_id);
    if (task_list_id > 0) {
      // this.task_list_id = task_list_id;
      store.dispatch("taskList/getTaskList", task_list_id).then(() => {
        to.params.page = task_list_id;
        next();
      });
    } else {
      next();
    }
  },
  mounted() {
    this.task_list_id = this.taskList.id;
  },
};
</script>
