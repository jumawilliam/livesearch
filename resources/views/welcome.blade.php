<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Search</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body  id="app">
    <div class="container">
    <form>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Search User</label>
    <input type="text" v-model="searchQuery"  class="form-control" >
  </div>
  <div class="card" v-if="results.length >0" >
  <div v-for="(result,index) in results" class="card-body">
     <p @click="selectedItem(result.id)">@{{result.name}}</p>
  </div>
</div>
<div class="card" v-show="userdetails">
  <div class="card-body">
    <p>User ID:@{{user.id}}</p>
    <p>User Name:@{{user.name}}</p>
    <p> User Email :@{{user.email}}</p>
  </div>
</div>
  </form>
    </div>
    <script>
        const {createApp}=Vue
        createApp({
            data(){
                return{
                    searchQuery:null,
                    results:[],
                    user:{},
                    userdetails:false,
                }
            },
            methods:{
                getResults(){
                    axios.get('/users/'+this.searchQuery).then(res=>{
                        this.results=res.data
                    }).catch(error=>{
                        console.log(error)
                    })
                },

                selectedItem(id){
                    axios.get('/user/'+id).then(res=>{
                        this.user=res.data
                        this.results=[]
                        this.userdetails=true
                    }).catch(error=>{
                        console.log(error)
                    })
                }
            },
            watch:{
    
                searchQuery(after,before){
                    this.getResults();
                }
            },
            mounted(){
                //alert('vue!')
            },

        }).mount('#app')
    </script>
</body>
</html>