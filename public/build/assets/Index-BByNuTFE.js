import{_ as C}from"./AuthenticatedLayout-BlfXxPpd.js";import{R as m}from"./PrimaryLinkButton-CZ9k2bom.js";import{i as p,C as x,f as r,a as s,b as e,w as u,F as D,j as k,o as d,d as w,t as b,u as n}from"./app-D2Fj5F7q.js";import{D as y,f as B,a as F,b as T}from"./faTrash-BCEt7l84.js";import{_ as $,F as g}from"./index.es-DWth5PxH.js";/* empty css                                                                          */import"./_plugin-vue_export-helper-DlAUqK2U.js";/* empty css            */const j={class:"section"},A={class:"is-flex mt-2 is-justify-content-space-between is-align-items-center"},E={class:"table is-fullwidth"},I={class:"is-flex"},z=Object.assign({layout:C},{__name:"Index",props:{categories:{type:Object}},setup(c){let f=p(null);const o=p(!1),a=x({}),h=l=>{f=l,o.value=!0},v=()=>{o.value=!1,a.clearErrors(),a.reset()},_=()=>{a.delete(route("categories.destroy",f),{preserveScroll:!0,onSuccess:()=>v(),onFinish:()=>a.reset()})};return(l,t)=>(d(),r("section",j,[s(y,{isActive:o.value,onClose:t[0]||(t[0]=i=>o.value=!1),onConfirm:_},null,8,["isActive"]),e("div",A,[t[2]||(t[2]=e("h1",{class:"title has-text-primary m-0"},"Categories",-1)),s(m,{class:"is-medium",href:l.route("categories.create")},{default:u(()=>t[1]||(t[1]=[w("+")])),_:1},8,["href"])]),e("table",E,[t[3]||(t[3]=e("thead",null,[e("tr",null,[e("th",null,[e("abbr",{title:"Title"},"Title")]),e("th",null,[e("abbr",{title:"Description"},"Description")]),e("th",null,[e("abbr",{title:"Actions"})])])],-1)),e("tbody",null,[(d(!0),r(D,null,k(c.categories.data,i=>(d(),r("tr",{key:i.id},[e("td",null,b(i.title),1),e("td",null,b(i.description),1),e("td",null,[e("div",I,[s(m,{class:"is-rounded mr-2 is-small",href:l.route("categories.edit",l.$id=i.id)},{default:u(()=>[s(n(g),{icon:n(B.faPencil)},null,8,["icon"])]),_:2},1032,["href"]),s(T,{onClick:M=>h(i.id),class:"is-danger button is-uppercase is-rounded is-small"},{default:u(()=>[s(n(g),{icon:n(F.faTrash)},null,8,["icon"])]),_:2},1032,["onClick"])])])]))),128))])]),s($,{pagination:c.categories},null,8,["pagination"])]))}});export{z as default};
