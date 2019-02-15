<template>
    <div class="container">
      <!-- asd -->
<div class="messaging">
  <div class="inbox_msg">
  <div class="inbox_people">
    <div class="headind_srch">
    <div class="recent_heading">
      <h4>Online </h4>
    </div>
    </div>
    <div class="inbox_chat scroll">
     <div v-for="userOnline in activeUsers">
      <div class="chat_list">
        <div class="chat_people">
          <div class="chat_img">
            <img src="https://picsum.photos/200/300"> 
          </div>
            <div class="chat_ib">
                <h5>{{userOnline.name}}</h5> 
                </div>
        </div>
      </div>
    </div>
    

    </div>
  </div>
  <div class="mesgs">
    <div  style="height:560px" class="msg_history" id="chatDiv"  v-on:scroll='checkScroll()'>

      
      <div v-for="mess in messages.slice().reverse()">
        
        <div v-if="mess.user_id != user_id">
         <div class="incoming_msg">
          <div class="incoming_msg_img"> <img src="https://picsum.photos/g/200/300
" > </div>

            <div style="-webkit-baseline-middle" class="received_msg">
              {{mess.username}}
          <div class="received_withd_msg">
            <p :title="mess.created_at">{{mess.messageBody}}</p>
            <span class="time_date"> </span>
            
        </div>
      </div>
    </div>
   
        </div>
        <div v-else="mess.user_id == user_id">
          <div class="outgoing_msg">
      <div class="sent_msg">
      <p>{{mess.messageBody}}</p>
       </div>
    </div>
    
        </div>
        <div :id="mess.message_id">
        </div>
      </div>
    


    </div>
    
    <div class="type_msg">
    
    <div class="input_msg_write">
     
      <input   class="write_msg" id="inputBox" type="text" @input="typing(username)" @focus="hasRead()" v-model="sendMessage" placeholder="Send a message">

      <button class="msg_send_btn"  type="button" v-on:click="sendAMessage()"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

    </div>
    </div>
  </div>
  </div>
</div>
  </div>
</template>
<script type="text/javascript">
export default{
data()
{
  return{
    messages:[],
    message:{},
    link:'',
    last:'',
    hasSeenArray:[],
    sendMessage:'',
    scroll:true,
    updated:false,
    prevScrollHeight:0,
    activeUsers:[],
    typingUsers:[],
    lastMessage:0,
    isActive:false
  };
},
props:{
  api_token:{
    type: String,
    required: true
   },
   username:{
    type: String,
    required: true
   },
   user_id:{
    type: String,
    required: true
   },
  },
  mounted(){
    window.addEventListener('beforeunload', this.refresh);
    this.listen();
  },
  created()
  {
  this.getMessages();
  },
  updated(){
    if( this.scroll == true ){
      this.scrollToBottom();
      this.scroll=false;
    }
    if( this.updated == true ){
      this.$el.querySelector("#chatDiv").scrollTop=this.$el.querySelector("#chatDiv").scrollHeight - this.prevScrollHeight;
    }
  },
  methods: {
    refresh(){
       window.Echo.join("FalangaChat").whisper('typing',{
             user:this.username,
             typing:false,
             id:this.user_id
           });
     },
    getMessages(){
      axios.get("/api/messages",{
        params:{
        api_token:this.api_token
      }}).then((data)=>{
        this.link=data.data.links.next;
        console.log(data);
        this.messages=data.data.data;
         this.lastRead();
      }).catch(err=>{console.log(err);});

    },
    typing(username){
      var alive=$("#inputBox").val();
      if(alive === ""){
        this.isActive=false;
         window.Echo.join("FalangaChat").whisper('typing',{
             user:this.username,
             typing:false,
             id:this.user_id
           });
        return;
      }
      if(!this.isActive){
       window.Echo.join("FalangaChat").whisper('typing',{
             user:this.username,
             typing:true,
             id:this.user_id
           });
          this.isActive=true;
        }

    },
    getPastMessages(){
      if(this.link === this.last){
        this.link=null;
        return;
      }
      axios.get(this.link,{
        params:{
        api_token:this.api_token
      }}).then((data)=>{
        this.link=data.data.links.next;
        this.last=data.data.links.last;
        console.log(data);
        this.messages=this.messages.concat(data.data.data);
      }).catch(err=>{console.log(err);});
    },
    checkScroll(){
      if(this.link == null)return;
      var div=this.$el.querySelector("#chatDiv");
      if(div.scrollTop == 0){
        this.prevScrollHeight=div.scrollHeight;
        this.getPastMessages();
        this.updated=true;
      }
    },
    scrollToBottom(){
      var div=this.$el.querySelector("#chatDiv");
      div.scrollTop=div.scrollHeight;
      console.log("HELLO");
    },
    sendAMessage(){
      axios.post("/api/save_message",
        {
          sendMessage:this.sendMessage
        },
      {
        headers: {
           'Content-Type': 'application/json',
       },
        params:{
        api_token:this.api_token
      }}).then((data)=>{
        console.log(data);
          axios.post('/api/has_read_message',
      {
        message_id:this.messages[0].message_id+1,
        user_id:this.user_id
      },
      {
        headers: {
           'Content-Type': 'application/json',
       },
        params:{
        api_token:this.api_token
      }}).then((data)=>{
        console.log(data);
      }).catch(err=>{console.log(err);});
      }).catch(err=>{console.log(err);});
      this.sendMessage='';

    window.Echo.join("FalangaChat").whisper('typing',{
             user:this.username,
             typing:false,
             id:this.user_id
           });
    },
    indexWhere(array, conditionFn) {
        var item = array.find(conditionFn);
        return array.indexOf(item);
    },
    lastRead(){
      axios.get('/api/last_read_messages',{
        params:{
        api_token:this.api_token
      }}).then((data)=>{
        //console.log(data);
        var arr=data.data.data;
        this.hasSeenArray=arr;
        console.log(this.hasSeenArray);
        for(var i=0;i<this.hasSeenArray.length;i++){
           var tmp = $("#"+this.hasSeenArray[i].message_id);
           if(tmp.length){
            if(this.hasSeenArray[i].user_id != this.user_id)
            this.createChildren(this.hasSeenArray[i].message_id,this.hasSeenArray[i].user_id,this.hasSeenArray[i].username);
           }
           if(this.hasSeenArray[i].user_id == this.user_id){
              this.lastMessage=this.hasSeenArray[i].message_id;
           }
      }
      }).catch(err=>{console.log(err);});
    },
    createChildren(mID,uID,name){
      $('#'+mID).append('<small id=\''+uID+'\' >'+name+'</small>');
    },
    deleteChild(mID,uID){
       $('#'+mID+' #'+uID).remove();
    },
    hasRead(){
      if(this.lastMessage == this.messages[0].message_id) return;

      console.log(this.lastMessage +" "+this.messages[0].message_id);

      window.Echo.join("FalangaChat").whisper('seen',{
          uID:this.user_id,
          username:this.username,
          mID:this.messages[0].message_id
      });
      //console.log(this.messages[0])
      console.log(this.messages[0].message_id)
      axios.post('/api/has_read_message',
      {
        message_id:this.messages[0].message_id,
        user_id:this.user_id
      },
      {
        headers: {
           'Content-Type': 'application/json',
       },
        params:{
        api_token:this.api_token
      }}).then((data)=>{
        console.log(data);
        this.lastMessage=this.messages[0].message_id;
      }).catch(err=>{console.log(err);});

    },
    listen(){
      window.Echo.join("FalangaChat")
      .here((users)=>{
        this.activeUsers=users;
      })
      .joining((user)=>{
          this.activeUsers.unshift(user);
        })
      .leaving((data)=>{
        this.activeUsers.splice(this.indexWhere(this.activeUsers, item => item.id === data.id),1);
      })
      .listen(".NewMessage",(data)=>{
       console.log(data);
       var div=this.$el.querySelector('#chatDiv');
       if((div.scrollHeight - div.scrollTop) < 500){
         this.scroll=true;
       }
        this.messages.unshift(data);
      if(data.user_id == this.user_id){
       window.Echo.join("FalangaChat").whisper('seen',{
          uID:this.user_id,
          username:this.username,
          mID:this.messages[0].message_id
      });
     }
     })
      .listenForWhisper('typing',(user)=>{
        if(user.typing){
          this.typingUsers.unshift(user);
        }else{
          this.typingUsers.splice(this.indexWhere(this.typingUsers, item => item.id === user.id),1);
        }
      }).
      listenForWhisper('seen',(user)=>{
        console.log(user.uID +" "+ user.mID);
        for(var i=0;i<this.hasSeenArray.length;i++){
            if(this.hasSeenArray[i].user_id == user.uID){
              console.log("Has seen")
              this.deleteChild(this.hasSeenArray[i].message_id,user.uID);
              this.createChildren(user.mID,user.uID,user.username);
              this.hasSeenArray[i].message_id=user.mID;
              return;
            }
        }
      });
      Echo.private('App.User.' + this.user_id)
       .notification((notification) => {
       console.log(notification);
       });
    }
  }
}

</script>


<style>

.container{
    max-width:900px;
}
.inbox_people {
  background: #fff;
  float: left;
  overflow: hidden;
  width: 30%;
  border-right: 1px solid #ddd;
}

.inbox_msg {
  border: 1px solid #ddd;
  clear: both;
  overflow: hidden;
}

.top_spac {
  margin: 20px 0 0;
}

.recent_heading {
  float: left;
  width: 40%;
}

.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%;
  padding:
}

.headind_srch {
  padding: 10px 29px 10px 20px;
  overflow: hidden;
  border-bottom: 1px solid #c4c4c4;
}

.recent_heading h4 {
  color: #0465ac;
    font-size: 16px;
    margin: auto;
    line-height: 29px;
}

.srch_bar input {
  outline: none;
  border: 1px solid #cdcdcd;
  border-width: 0 0 1px 0;
  width: 80%;
  padding: 2px 0 4px 6px;
  background: none;
}

.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}

.srch_bar .input-group-addon {
  margin: 0 0 0 -27px;
}

.chat_ib h5 {
  font-size: 15px;
  color: #464646;
  margin: 0 0 8px 0;
}

.chat_ib h5 span {
  font-size: 13px;
  float: right;
}

.chat_ib p {
    font-size: 12px;
    color: #989898;
    margin: auto;
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chat_img {
  float: left;
  width: 11%;
}

.chat_img img {
  width: 100%
}

.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people {
  overflow: hidden;
  clear: both;
}

.chat_list {
  border-bottom: 1px solid #ddd;
  margin: 0;
  padding: 18px 16px 10px;
}

.inbox_chat {
  height: 550px;
  overflow-y: scroll;
}

.active_chat {
  background: #e8f6ff;
}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
  margin:20px 0 20px 0;
}

.incoming_msg_img img {
  width: 100%;
}

.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
  color:blue;
  vertical-align:-webkit-baseline-middle;
}

.received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 0 15px 15px 15px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}

.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}

.received_withd_msg {
  width: 57%;
}

.mesgs{
  float: left;
  padding: 30px 15px 0 25px;
  width:70%;
}

.sent_msg p {
  background:#0465ac;
  border-radius: 12px 15px 15px 0;
  font-size: 14px;
  margin: 0;
  color: #fff;
  padding: 5px 10px 5px 12px;
  width: 100%;
}

.outgoing_msg {
  overflow: hidden;
  margin: 26px 0 26px;
}

.sent_msg {
  float: right;
  width: 46%;
}

.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
  outline:none;
}

.type_msg {
  border-top: 1px solid #c4c4c4;
  position: relative;
}

.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border:none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 15px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}

.messaging {
  padding: 0 0 50px 0;
}

.msg_history {

  overflow-y: scroll;
}

</style>
