import { getError } from "@/utils/helpers";
import TaskListService from "@/services/TaskListService";

export const namespaced = true;

function setPaginatedTaskLists(commit, response) {
  commit("SET_TASK_LISTS", response.data.data);
  commit("SET_META", response.data.meta);
  commit("SET_LINKS", response.data.links);
  commit("SET_LOADING", false);
}

function setTaskList(commit, response) {
  commit("SET_TASK_LIST", response.data.data);
  commit("SET_LOADING", false);
}

export const state = {
  taskLists: [],
  taskList: {},
  taskListStat: [],
  meta: null,
  links: null,
  loading: false,
  error: null,
};

export const mutations = {
  SET_TASK_LIST_STAT(state, taskListStat) {
    // console.log('SET_TASK_LIST_STAT ', taskListStat);
    state.taskListStat = taskListStat;
  },
  SET_TASK_LISTS(state, taskLists) {
    state.taskLists = taskLists;
  },
  SET_TASK_LIST(state, taskList) {
    // console.log('SET_TASK_LIST ', taskList);
    state.taskList = taskList;
  },
  SET_META(state, meta) {
    state.meta = meta;
  },
  SET_LINKS(state, links) {
    state.links = links;
  },
  SET_LOADING(state, loading) {
    state.loading = loading;
  },
  SET_ERROR(state, error) {
    state.error = error;
  },
};

export const actions = {
  getTaskLists({ commit }, page) {
    commit("SET_LOADING", true);
    TaskListService.getTaskLists(page)
      .then((response) => {
        setPaginatedTaskLists(commit, response);
      })
      .catch((error) => {
        commit("SET_LOADING", false);
        commit("SET_ERROR", getError(error));
      });
  },
  getTaskList({ commit }, id) {
    commit("SET_LOADING", true);
    TaskListService.getTaskList(id)
      .then((response) => {
        setTaskList(commit, response);
      })
      .catch((error) => {
        commit("SET_LOADING", false);
        commit("SET_ERROR", getError(error));
      });
  },
  updateTaskList({ commit }, payload) {
    return TaskListService.updateTaskList(payload).then(() => {
      commit("SET_LOADING", false);
      alert("Updated");
    });
  },
  createTaskList({ commit }, payload) {
    return TaskListService.createTaskList(payload).then(() => {
      commit("SET_LOADING", false);
      alert("Created");
      window.location = "/task-lists";
    });
  },
  deleteTask({ commit }, payload) {
    return TaskListService.deleteTaskList(payload).then(() => {
      commit("SET_LOADING", false);
      alert("Deleted");
      window.location = "/task-lists";
    });
  },
  getStat({ commit }, payload) {
    return TaskListService.getStat(payload).then((response) => {
      commit("SET_TASK_LIST_STAT", response.data);
    });
  },
  paginateTaskLists({ commit }, link) {
    commit("SET_LOADING", true);
    TaskListService.paginateTaskLists(link)
      .then((response) => {
        setPaginatedTaskLists(commit, response);
      })
      .catch((error) => {
        commit("SET_LOADING", false);
        commit("SET_ERROR", getError(error));
      });
  },
};

export const getters = {
  taskLists: (state) => {
    // console.log('getters.taskLists ', state.taskLists);
    return state.taskLists;
  },
  taskList: (state) => {
    return state.taskList;
  },
  taskListStat: (state) => {
    return state.taskListStat;
  },
  meta: (state) => {
    return state.meta;
  },
  links: (state) => {
    return state.links;
  },
  loading: (state) => {
    return state.loading;
  },
  error: (state) => {
    return state.error;
  },
};
