<?php
header("Content-type:text/html;charset=UTF-8");
session_start();
$username1=@$_SESSION['username'];
if($username1)
{
echo<<<EOF

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Public Seat Cleaning Systerm</title>
  <link rel="icon" href="./images/favicon.ico">
  <link rel="stylesheet" href="CSS/index.css">
  <link rel="stylesheet" href="CSS/bootstrap.min.css">
  <script src="Js/jquery.js"></script>
  <script src="JS/index.js"></script>
  <script src="JS/bootstrap.min.js"></script>
  <script src="JS/vue.js"></script>
</head>

<body>
  <!-- 导航条 -->
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
          data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#########"><img id="navbar-brand" src="images/timg.jpg" alt="Brand"></a>
        <a class="navbar-brand" href="#">Public Seat Cleaning Systerm </a><span class="sr-only">(current)</span></a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
              aria-expanded="false">
              Root<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">我的信息</a></li>
              <li><a href="#">切换账号</a></li>
              <li><a href="#">注销</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">帮助</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>

    <!-- 左侧导航条 -->
  </nav>
  <div class="list-group">
    <a href="#" class="list-group-item active"> 欢迎页</a>
    <a href="userinfo.html" class="list-group-item">用户管理</a>
    <!-- <a href="#" class="list-group-item">权限管理</a>
    <a href="#" class="list-group-item">应用管理</a>
    <a href="#" class="list-group-item">操作日志</a> -->
  </div>


  <!-- 表格 -->
  <div class="container" id="app">
    <div>
      <input type="text" placeholder="search" @input="search" list="cars" class="search">
      <datalist id="cars">
        <option v-for="item in searchlist" :value="item"></option>
      </datalist>
      <input type="button" class="add" @click="add" value="新增">
    </div>
    <div>
      <table>
        <tr>
          <th>设备id</th>
          <th>地址</th>
          <th>负责人</th>
          <th>清洁剂剩余量</th>
          <th>上次清洗时间</th>
          <th>操作</th>
        </tr>
        <tr v-cloak v-for="(item, index) of slist">
          <td>{{index+1}}</td>
          <td>{{item.address}}</td>
          <td>{{item.principal}}</td>
          <td>{{item.surplus}}</td>
          <td>{{item.last_time}}</td>
          <td><a class="operation" href="javascript:;" @click="showOverlay(index)">修改</a> | <a class="operation" href="javascript:;"
              @click="del(index)">删除</a></td>
        </tr>
      </table>
    </div>
    <model :list='selectedlist' :isactive="isActive" v-cloak @change="changeOverlay" @modify="modify"></model>
  </div>
  <footer>
    <div class="footer">
      Copyright &copy; 2020-2021 NSU.IOT
    </div>
  </footer>
</body>
<!-- vue部分 -->
<script>
  Vue.component('model', {
    props: ['list', 'isactive'],
    template: `<div class="overlay" v-show="isactive">
                    <div class="con">
                    <h2 class="title">新增 | 修改</h2>
                    <div class="content">
                    <table>
                    <tr>
                    <td>地址</td>
                    <td><input type="text" v-model="modifylist.address"></td>
                    </tr>
                    <tr>
                    <td>负责人</td>
                    <td><input type="text" v-model="modifylist.principal"></td>
                    </tr>
                    <tr>
                    <td>清洁剂剩余量</td>
                    <td>
                    <select name="" id="" v-model="modifylist.surplus">
                    <option value="90%左右">90%左右</option>
                    <option value="70%左右">70%左右</option>
                    <option value="50%左右">50%左右</option>
                    <option value="30%左右">30%左右</option>
                    <option value="10%左右">10%左右</option>
                    <option value="不足5%">不足5%</option>
                    </td>
                    </tr>
                    <tr>
                    <td>上次清洗时间</td>
                    <td>
                    <select name="" id="" v-model="modifylist.last_time">
                    <option value="一天前">一天前</option>
                    <option value="二天前">二天前</option>
                    <option value="三天前">三天前</option>
                    <option value="五天前">五天前</option>
                    </select>
                    </td>
                    </tr>
                    
                    </table>
                    <p>
                    <input type="button" @click="changeActive" value="取消">
                    <input type="button" @click="modify" value="保存">
                    </p>
                    </div>
                    </div>
                </div>`,
    computed: {
      modifylist() {
        return this.list;
      }
    },
    methods: {
      changeActive() {
        this.emit('change');
      },
      modify() {
        this.emit('modify', this.modifylist);
      }
    }
  });
  var app = new Vue({
    el: '#app',
    data: {
      isActive: false,
      selected: -1,
      selectedlist: {},
      slist: [],
      searchlist: [],
      list: [
        {
          address: '成都东软学院c1座A区',
          principal: '黄一',
          surplus: '90%左右',
          last_time: '一天前'
        },
        {
          address: '成都东软学院B2座A区',
          principal: '张二',
          surplus: '90%左右',
          last_time: '二天前'
        },
        {
          address: '成都东软学院D5座B区',
          principal: '肖三一',
          surplus: '30%左右',
          last_time: '一天前'
        },
        {
          address: '成都东软学院c3座D区',
          principal: '李华',
          surplus: '不足5%',
          last_time: '一天前'
        },
        {
          address: '成都东软学院c3座A区',
          principal: '李娟',
          surplus: '10%左右',
          last_time: '二天前'
        },
        {
          address: '成都东软学院c3座E区',
          principal: '李肖华',
          surplus: '90%左右',
          last_time: '一天前'
        },
        {
          address: '成都东软学院c3座B区',
          principal: '龙一天',
          surplus: '30%左右',
          last_time: '一天前'
        },
        {
          address: '成都东软学院c2座D区',
          principal: '赵四',
          surplus: '70%左右',
          last_time: '一天前'
        },
        {
          address: '成都东软学院c3座C区',
          principal: '刘六',
          surplus: '90%左右',
          last_time: '一天前'
        },
        {
          address: '成都东软学院A5座D区',
          principal: '章琪',
          surplus: '70%左右',
          last_time: '三天前'
        }
      ]
    },
    created() {
      console.log(Date.now());
      this.setSlist(this.list);
    },
    methods: {
      // 修改数据
      showOverlay(index) {
        this.selected = index;
        this.selectedlist = this.list[index];
        this.changeOverlay();
      },
      // 点击保存按钮
      modify(arr) {
        if (this.selected > -1) {
          Vue.set(this.list, this.selected, arr);
        } else {
          this.list.push(arr);
        }
        this.setSlist(this.list);
        this.changeOverlay();
      },
      // 添加数据
      add: function () {
        this.selectedlist = {
          address: '',
          principal: '',
          surplus: '90%左右',
          last_time: '一天前'
        };
        this.isActive = true;
      },
      // 删除数据
      del(index) {
        var e = confirm("确认删除该条数据？");
        if (e == 1) {
          this.list.splice(index, 1);
          this.setSlist(this.list);
        }
        else {
          alert("您取消了删除！");
        }

      },

      changeOverlay() {
        this.isActive = !this.isActive;
      },
      // 获取需要渲染到页面中的数据
      setSlist(arr) {
        this.slist = JSON.parse(JSON.stringify(arr));
      },
      // 搜索
      search(e) {
        var v = e.target.value,
          self = this;
        self.searchlist = [];
        if (v) {
          var ss = [];
          // 过滤需要的数据
          this.list.forEach(function (item) {
            if (item.address.indexOf(v) > -1) {
              if (self.searchlist.indexOf(item.address) == -1) {
                self.searchlist.push(item.address);
              }
              ss.push(item);
            } else if (item.principal.indexOf(v) > -1) {
              if (self.searchlist.indexOf(item.principal) == -1) {
                self.searchlist.push(item.principal);
              }
              ss.push(item);
            }
          });
          this.setSlist(ss);
        } else {
          // 没有搜索内容，则展示全部数据
          this.setSlist(this.list);
        }
      }
    },
    watch: {
    }
  })
</script>

</html>

EOF;
	}
else 
{
	echo "<script>alert('您尚未登录，请登录!');location='login.php';</script>";
	}
?>