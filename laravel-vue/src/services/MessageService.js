import * as API from "@/services/API";

export default {
  getMessages() {
    return API.apiClient.get(`/messages`);
  },
  postMessage(payload) {
    return API.apiClient.post("/messages", payload);
  },
  paginateMessages(link) {
    return API.apiClient.get(link);
  },
};
