(window.webpackJsonp=window.webpackJsonp||[]).push([[28],{"/b0R":function(t,a,e){"use strict";e.r(a);var s={components:{Layout:e("+SZM").a},props:{notifications:{type:Array,default:null},employees:{type:Array,default:null}},mounted:function(){localStorage.success&&(this.$snotify.success(localStorage.success,{timeout:2e3,showProgressBar:!0,closeOnClick:!0,pauseOnHover:!0}),localStorage.clear())}},i=(e("WuGc"),e("KHd+")),n=Object(i.a)(s,(function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("layout",{attrs:{title:"Home",notifications:t.notifications}},[e("div",{staticClass:"ph2 ph0-ns"},[e("div",{staticClass:"mt4-l mt1 mw6 br3 bg-white box center breadcrumb relative z-0 f6 pb2"},[e("ul",{staticClass:"list ph0 tc-l tl"},[e("li",{staticClass:"di"},[e("inertia-link",{attrs:{href:"/"+t.$page.auth.company.id+"/dashboard"}},[t._v(t._s(t.$page.auth.company.name))])],1),t._v(" "),e("li",{staticClass:"di"},[e("inertia-link",{attrs:{href:"/"+t.$page.auth.company.id+"/account"}},[t._v(t._s(t.$t("app.breadcrumb_account_home")))])],1),t._v(" "),e("li",{staticClass:"di"},[t._v("\n          "+t._s(t.$t("app.breadcrumb_account_manage_employees"))+"\n        ")])])]),t._v(" "),e("div",{staticClass:"mw7 center br3 mb5 bg-white box restricted relative z-1"},[e("div",{staticClass:"pa3 mt5"},[e("h2",{staticClass:"tc normal mb4"},[t._v("\n          "+t._s(t.$t("account.employees_title",{company:t.$page.auth.company.name}))+"\n        ")]),t._v(" "),e("p",{staticClass:"relative adminland-headline"},[e("span",{staticClass:"dib mb3 di-l"},[t._v("\n            "+t._s(t.$tc("account.employees_number_employees",t.employees.length,{company:t.$page.auth.company.name,count:t.employees.length}))+"\n          ")]),t._v(" "),e("inertia-link",{staticClass:"btn absolute-l relative dib-l db right-0",attrs:{href:"/"+t.$page.auth.company.id+"/account/employees/create","data-cy":"add-employee-button"}},[t._v("\n            "+t._s(t.$t("account.employees_cta"))+"\n          ")])],1),t._v(" "),e("ul",{staticClass:"list pl0 mt0 center"},t._l(t.employees,(function(a){return e("li",{key:a.id,staticClass:"flex items-center lh-copy pa3-l pa1 ph0-l bb b--black-10 employee-item"},[e("img",{staticClass:"w2 h2 w3-ns h3-ns br-100",attrs:{src:a.avatar,width:"64",height:"64"}}),t._v(" "),e("div",{staticClass:"pl3 flex-auto"},[e("span",{staticClass:"db black-70",attrs:{name:a.name,"data-invitation-link":a.invitation_link}},[t._v("\n                "+t._s(a.name)+"\n              ")]),t._v(" "),e("ul",{staticClass:"f6 list pl0"},[e("li",{staticClass:"di pr2"},[e("span",{staticClass:"badge f7"},[t._v("\n                    "+t._s(t.$t("app.permission_"+a.permission_level))+"\n                  ")])]),t._v(" "),e("li",{staticClass:"di pr2"},[e("inertia-link",{attrs:{href:"/"+t.$page.auth.company.id+"/employees/"+a.id,"data-cy":"employee-view"}},[t._v("\n                    "+t._s(t.$t("app.view"))+"\n                  ")])],1),t._v(" "),e("li",{staticClass:"di pr2"},[e("inertia-link",{attrs:{href:"/account/employees/"+a.id+"/permissions"}},[t._v("\n                    "+t._s(t.$t("account.employees_change_permission"))+"\n                  ")])],1),t._v(" "),e("li",{staticClass:"di pr2"},[e("inertia-link",{attrs:{href:"/employees/"+a.id+"/lock"}},[t._v("\n                    "+t._s(t.$t("account.employees_lock_account"))+"\n                  ")])],1),t._v(" "),e("li",{staticClass:"di"},[e("inertia-link",{attrs:{href:"/account/employees/"+a.id+"/destroy"}},[t._v("\n                    "+t._s(t.$t("app.delete"))+"\n                  ")])],1)])])])})),0)])])])])}),[],!1,null,"027c48ac",null);a.default=n.exports},Uld0:function(t,a,e){var s=e("fs0i");"string"==typeof s&&(s=[[t.i,s,""]]);var i={hmr:!0,transform:void 0,insertInto:void 0};e("aET+")(s,i);s.locals&&(t.exports=s.locals)},WuGc:function(t,a,e){"use strict";var s=e("Uld0");e.n(s).a},fs0i:function(t,a,e){(t.exports=e("I1BE")(!1)).push([t.i,".employee-item[data-v-027c48ac]:last-child {\n  border-bottom: 0;\n}",""])}}]);
//# sourceMappingURL=28.js.map?id=af2027697914d27aa2a8