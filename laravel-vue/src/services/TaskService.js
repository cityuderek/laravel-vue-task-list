import * as API from "@/services/API";

export default {
  getTasks() {
    return API.apiClient.get(`/tasks`);
  },
  getTask(taskListId) {
    return API.apiClient.get(`/tasks/${taskListId}`);
  },
  createTask(payload) {
    return API.apiClient.post("/tasks", payload);
  },
  updateTask(payload) {
    return API.apiClient.put(`/tasks/${payload.id}`, payload);
  },
  deleteTask(payload) {
    return API.apiClient.delete(`/tasks/${payload.id}`, payload);
  },
  setDone(payload) {
    return API.apiClient.post(
      `/tasks/set_done/${payload.id}/${payload.is_done}`,
      payload
    );
  },
  paginateTasks(link) {
    return API.apiClient.get(link);
  },
};
