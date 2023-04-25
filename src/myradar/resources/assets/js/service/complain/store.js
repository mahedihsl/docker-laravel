import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import EventBus from '../../util/EventBus';
import ComplainApi from '../../../js/api/ComplainApi';

export default new Vuex.Store({
  state:{
    current: 0,
    currentContent: 0,
    complainList:[],
    selectedComplain:"",
    search: {
        reg: '',
        com: '',
        phone: '',
    },
    pagination: {
        total: 0,
        per_page: 15,
        total_pages: 0,
        current_page: 1,
    },
    offset: 4,
  },
  getters:{
    complainList(state){
      return state.complainList;
    },
    pagination(state){
      return state.pagination;
    },
    offset(state){
      return state.offset;
    },
    selectedComplain(state){
      return state.selectedComplain;
    },
    currentContent(state){
      return state.currentContent;
    }
  },
  mutations:{
    changeView(state, val){
      state.current = val;
    },
    complainList(state, data){
      state.complainList = data;
      if(state.selectedComplain){
        state.selectedComplain = state.complainList.find(o => o.id == state.selectedComplain.id);
      }
    },
    pagination(state, data){
      //console.log(data.pagination);
      state.pagination = data.pagination;
    },
    selectedComplain(state, data){
      state.selectedComplain = data;
    },
    changeContent(state,val){
      state.currentContent = val;
    }
  },
  actions:{
    save({commit,state}, data){
      //let ComplainApi = new ComplainApi(EventBus);
      ComplainApi.save(data).then(result => {
        EventBus.$emit('complain-save-finish',result);
      })
    },

    getComplains({commit,state}, params){
      ComplainApi.getComplains(params.page, params.user_id).then(result => {

        commit('complainList', result.data);
        commit('pagination', result.meta);
        EventBus.$emit('complain-list-found', result);
      })
    },

    search({commit,state}, data){
      ComplainApi.search(data).then(result => {
        commit('complainList', result.data);
        commit('pagination', result.meta);
        EventBus.$emit('complain-list-found', result);
      })
    },

    addComment({commit,state},data){
		const sel_id = state.selectedComplain.id;
      let info = {
        ...state.selectedComplain,
        type: data.type,
        review: data.review,
        comment:data.comment,
        new_status:data.status,
		    responsible: data.responsible,
     };

      ComplainApi.addComment(info).then(result => {
		  if (result.status) {
		  	for (var i = 0; i < state.complainList.length; i++) {
		  		if (state.complainList[i].id == sel_id) {
					state.complainList[i].status = data.status;
					state.complainList[i].responsible = data.responsible;
		  		}
		  	}
		  }
        EventBus.$emit('comment-add-finish', result);
      })
    },
  },
})
