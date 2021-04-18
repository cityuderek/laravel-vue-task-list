import * as API from "@/services/API";

export default {
  getTaskLists() {
    return API.apiClient.get(`/task_lists`);
  },
  getTaskList(taskListId) {
    return API.apiClient.get(`/task_lists/${taskListId}`);
  },
  createTaskList(payload) {
    return API.apiClient.post("/task_lists", payload);
  },
  updateTaskList(payload) {
    return API.apiClient.put(`/task_lists/${payload.id}`, payload);
  },
  getStat(payload) {
    return API.apiClient.get(`/task_lists/one_hour_stat/${payload}`);
  },
  deleteTaskList(payload) {
    return API.apiClient.delete(`/task_lists/${payload.id}`, payload);
  },
  paginateTaskLists(link) {
    return API.apiClient.get(link);
  },
};
