<?php
header("Content-type:text/html;charset=UTF-8");
$username=@$_SESSION['username'];
if($username)
{
echo<<<EOF
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>userinfo</title>
    <link rel="icon" href="./images/favicon.ico">
    <link rel="stylesheet" href="./CSS/userinfo.css">
    <script src="./JS/vue.js"></script>
    <script src="./JS/jquery.js"></script>
</head>
<body>
  <div class="title">
    用户管理
  </div>
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
              <th>编号</th>
              <th>负责人</th>
              <th>账号</th>
              <th>密码</th>
              <th>操作</th>
            </tr>
            <tr v-cloak v-for="(item, index) of slist">
              <td>{{index+1}}</td>
              <td>{{item.principal}}</td>
              <td>{{item.id}}</td>
              <td>{{item.password}}</td>
              <td><a class="operation" href="javascript:;" @click="showOverlay(index)">修改</a> | <a  class="operation" href="javascript:;"
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
                        <td>负责人</td>
                        <td><input type="text" v-model="modifylist.principal"></td>
                        </tr>
                        <tr>
                        <td>账号</td>
                        <td><input type="text" v-model="modifylist.id"></td>
                        </tr>
                        <tr>
                        <td>密码</td>
                        <td><input type="text" v-model="modifylist.password"></td>
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
              principal: '黄一',
              id:'19310',
              password:'a1s2d3f4'
            },
            {
              principal: '张二',
              id: '12345',
              password: 's2222'
            },
            {
              principal: '肖三一',
              id: '12346',
              password: 's3333'
            },
            {
              principal: '李华',
              id: '12347',
              password: 's4444'
            },
            {
              principal: '李娟',
              id: '12389',
              password: 's5555'
            },
            {
              principal: '李肖华',
              id: '28094',
              password: 's6666'
            },
            {
              principal: '龙一天',
              id: '98745',
              password: 's7777'
            },
            {
              principal: '赵四',
              id: '67038',
              password: 's8888'
            },
            {
              principal: '刘六',
              id: '45690',
              password: 's9999'
            },
            {
              principal: '章琪',
              id: '66666',
              password: 'sss77'
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
              principal: '00000',
              id: '00000',
              password: '00000'
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
                if (item.id.indexOf(v) > -1) {
                  if (self.searchlist.indexOf(item.id) == -1) {
                    self.searchlist.push(item.id);
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
else echo "<script>alert('您尚未登录，请登录!');location='login';</script>";
?>