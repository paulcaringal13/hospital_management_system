import { createStore } from "vuex";
import axiosClient from "../../axios/axios";

export default createStore({
  state: {
    user: {
      name: localStorage.getItem("name"),
      id: localStorage.getItem("id"),
      email: localStorage.getItem("email"),
    },
  },
  mutations: {
    setUser(state, currentUser) {
      state.user = currentUser;
    },
  },

  actions: {
    getUser({ commit }, user_id) {
      axiosClient
        .get(`/user/${user_id}`)
        .then((res) => {
          commit("setUser", res.data);
        })
        .catch((err) => console.log(err));
    },
  },
});
