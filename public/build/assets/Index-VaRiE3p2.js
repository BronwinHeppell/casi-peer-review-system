import{_ as g}from"./AuthenticatedLayout-BlfXxPpd.js";import{R as d}from"./PrimaryLinkButton-CZ9k2bom.js";import{D as x,f as j,a as k,b as D}from"./faTrash-BCEt7l84.js";import{i as v,C as F,f as c,b as e,a as s,w as r,F as T,j as _,o as f,d as y,t as b,u}from"./app-D2Fj5F7q.js";import{_ as B,F as h}from"./index.es-DWth5PxH.js";/* empty css                                                                          */import"./_plugin-vue_export-helper-DlAUqK2U.js";/* empty css            */const E={class:"section"},q={class:"breadcrumb","aria-label":"breadcrumbs"},A=["href"],Q=["href"],R={class:"is-flex mt-2 is-justify-content-space-between is-align-items-center"},$={class:"table is-fullwidth"},I={class:"is-flex"},M={class:"is-flex is-justify-content-end"},J=Object.assign({layout:g},{__name:"Index",props:{reviewCycle:{type:Object},questions:{type:Object}},setup(i){let m=v(null);const a=v(!1),o=F({}),w=l=>{m=l,a.value=!0},p=()=>{a.value=!1,o.clearErrors(),o.reset()},C=()=>{o.delete(route("questions.destroy",m),{preserveScroll:!0,onSuccess:()=>p(),onFinish:()=>o.reset()})};return(l,t)=>(f(),c("section",E,[e("nav",q,[e("ul",null,[e("li",null,[e("a",{href:l.route("review_cycles.index")},"Review Cycles",8,A)]),e("li",null,[e("a",{href:l.route("review_cycles.edit",i.reviewCycle.id)},"Edit Review Cycle",8,Q)]),t[1]||(t[1]=e("li",{class:"is-active"},[e("a",{href:"#","aria-current":"page"},"Questions")],-1))])]),s(x,{isActive:a.value,onClose:t[0]||(t[0]=n=>a.value=!1),onConfirm:C},null,8,["isActive"]),e("div",R,[t[3]||(t[3]=e("h1",{class:"title has-text-primary m-0"},"Questions",-1)),s(d,{class:"is-medium",href:l.route("questions.create",i.reviewCycle.id)},{default:r(()=>t[2]||(t[2]=[y("+")])),_:1},8,["href"])]),e("table",$,[t[4]||(t[4]=e("thead",null,[e("tr",null,[e("th",null,[e("abbr",{title:"Title"},"Title")]),e("th",null,[e("abbr",{title:"Title"},"Category")]),e("th",null,[e("abbr",{title:"Actions"})])])],-1)),e("tbody",null,[(f(!0),c(T,null,_(i.questions.data,n=>(f(),c("tr",{key:n.id},[e("td",null,b(n.question),1),e("td",null,b(n.category.title),1),e("td",null,[e("div",I,[s(d,{class:"is-rounded is-small mr-2",href:l.route("questions.edit",[i.reviewCycle.id,n.id])},{default:r(()=>[s(u(h),{icon:u(j.faPencil)},null,8,["icon"])]),_:2},1032,["href"]),s(D,{onClick:N=>w(n.id),class:"is-danger button is-uppercase is-rounded is-small"},{default:r(()=>[s(u(h),{icon:u(k.faTrash)},null,8,["icon"])]),_:2},1032,["onClick"])])])]))),128))])]),s(B,{pagination:i.questions},null,8,["pagination"]),e("div",M,[s(d,{href:i.questions.data.length===0?"#":l.route("review_cycles.finalise",i.reviewCycle.id),class:"is-primary is-medium"},{default:r(()=>t[5]||(t[5]=[y("Finalise Cycle ")])),_:1},8,["href"])])]))}});export{J as default};
