<template>
    <div class="container">
        <h3>Chat</h3>
      <div id="chatDiv" style='max-height:300px; overflow-y:auto;' v-on:scroll='checkScroll()'>
      <div v-for="mess in messages.slice().reverse()">
        <b>{{mess.username}}</b>
        <p>{{mess.messageBody}}</p>
        <div :id="mess.message_id">
        </div>
      </div>
    </div>
    <div v-if="typingUsers.length != 0">
     <small v-for="user in typingUsers">
          {{user.user}}
      </small>
      <small v-if="typingUsers.length > 1">are typing...</small>
      <small v-if="typingUsers.length == 1">is typing...</small>
    </div>
      <input id="inputBox" type="textarea" @input="typing(username)" @focus="hasRead()" v-model="sendMessage" placeholder="Send a message">
      <button v-on:click="sendAMessage()">Send</button>
  <div v-for="userOnline in activeUsers">
      <li>{{userOnline.name}}</li>
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
      Echo.private('App.User.' + this.user)
       .notification((notification) => {
       console.log(notification);
       });
    }
  }
}

</script>

<style>
</style>
