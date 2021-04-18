import { getError } from "@/utils/helpers";
import TaskService from "@/services/TaskService";

export const namespaced = true;

function setPaginatedTasks(commit, response) {
  commit("SET_TASKS", response.data.data);
  commit("SET_META", response.data.meta);
  commit("SET_LINKS", response.data.links);
  commit("SET_LOADING", false);
}

function setTask(commit, response) {
  commit("SET_TASK", response.data.data);
  commit("SET_LOADING", false);
}

export const state = {
  tasks: [],
  task: {},
  meta: null,
  links: null,
  loading: false,
  error: null,
};

export const mutations = {
  SET_TASKS(state, tasks) {
    state.tasks = tasks;
  },
  SET_TASK(state, task) {
    state.task = task;
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
  getTasks({ commit }, page) {
    commit("SET_LOADING", true);
    TaskService.getTasks(page)
      .then((response) => {
        setPaginatedTasks(commit, response);
      })
      .catch((error) => {
        commit("SET_LOADING", false);
        commit("SET_ERROR", getError(error));
      });
  },
  getTask({ commit }, id) {
    commit("SET_LOADING", true);
    TaskService.getTask(id)
      .then((response) => {
        setTask(commit, response);
      })
      .catch((error) => {
        commit("SET_LOADING", false);
        commit("SET_ERROR", getError(error));
      });
  },
  updateTask({ commit }, payload) {
    return TaskService.updateTask(payload).then(() => {
      commit("SET_LOADING", false);
      alert("Updated");
    });
  },
  setDone({ commit }, payload) {
    return TaskService.setDone(payload).then(() => {
      commit("SET_LOADING", false);
      alert("Set success");
      location.reload();
    });
  },
  createTask({ commit }, payload) {
    return TaskService.createTask(payload).then(() => {
      commit("SET_LOADING", false);
      alert("Created");
      window.location = "/task-lists";
    });
  },
  deleteTask({ commit }, payload) {
    return TaskService.deleteTask(payload).then(() => {
      commit("SET_LOADING", false);
      alert("Deleted");
      window.location = "/task-lists";
    });
  },
  paginateTasks({ commit }, link) {
    commit("SET_LOADING", true);
    TaskService.paginateTasks(link)
      .then((response) => {
        setPaginatedTasks(commit, response);
      })
      .catch((error) => {
        commit("SET_LOADING", false);
        commit("SET_ERROR", getError(error));
      });
  },
};

export const getters = {
  tasks: (state) => {
    return state.tasks;
  },
  task: (state) => {
    return state.task;
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
