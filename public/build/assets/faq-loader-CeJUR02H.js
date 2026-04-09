import{r as i,j as e,R as g,a as j}from"./client-CU1SI9-t.js";import{B as w}from"./index-CMmoeHmW.js";/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const v=r=>r.replace(/([a-z0-9])([A-Z])/g,"$1-$2").toLowerCase(),y=r=>r.replace(/^([A-Z])|[\s-_]+(\w)/g,(t,n,a)=>a?a.toUpperCase():n.toLowerCase()),x=r=>{const t=y(r);return t.charAt(0).toUpperCase()+t.slice(1)},h=(...r)=>r.filter((t,n,a)=>!!t&&t.trim()!==""&&a.indexOf(t)===n).join(" ").trim();/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */var N={xmlns:"http://www.w3.org/2000/svg",width:24,height:24,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor",strokeWidth:2,strokeLinecap:"round",strokeLinejoin:"round"};/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const C=i.forwardRef(({color:r="currentColor",size:t=24,strokeWidth:n=2,absoluteStrokeWidth:a,className:l="",children:o,iconNode:m,...d},s)=>i.createElement("svg",{ref:s,...N,width:t,height:t,stroke:r,strokeWidth:a?Number(n)*24/Number(t):n,className:h("lucide",l),...d},[...m.map(([u,c])=>i.createElement(u,c)),...Array.isArray(o)?o:[o]]));/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const p=(r,t)=>{const n=i.forwardRef(({className:a,...l},o)=>i.createElement(C,{ref:o,iconNode:t,className:h(`lucide-${v(x(r))}`,`lucide-${r}`,a),...l}));return n.displayName=x(r),n};/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const q=[["path",{d:"m6 9 6 6 6-6",key:"qrunsl"}]],k=p("chevron-down",q);/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A=[["path",{d:"m18 15-6-6-6 6",key:"153udz"}]],F=p("chevron-up",A);function E({idBase:r,buttonId:t,panelId:n,question:a,answer:l}){const[o,m]=i.useState(!1),d=()=>m(s=>!s);return e.jsxs("div",{className:"bg-white/10 backdrop-blur-md rounded-md text-white px-4 py-3","data-open":o?"true":"false",children:[e.jsx("h3",{className:"m-0",children:e.jsxs("button",{id:t,type:"button",onClick:d,"aria-expanded":o,"aria-controls":n,className:"w-full flex justify-between items-center font-semibold uppercase text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-[#8F1E98] rounded-md py-1",children:[e.jsx("span",{children:a}),e.jsx("span",{"aria-hidden":"true",className:"ml-2",children:o?e.jsx(F,{size:18,"aria-hidden":"true",focusable:"false"}):e.jsx(k,{size:18,"aria-hidden":"true",focusable:"false"})})]})}),e.jsx("div",{id:n,role:"region","aria-labelledby":t,hidden:!o,className:"mt-2 text-sm text-white/80",children:e.jsx("p",{children:l})})]})}function I(){const[r,t]=i.useState([]),[n,a]=i.useState(!0),[l,o]=i.useState(null),d="faq-heading";return i.useEffect(()=>{fetch("/api/faqs").then(s=>{if(!s.ok)throw new Error("Impossible de charger la FAQ");return s.json()}).then(s=>{const u=Array.isArray(s)?s:(s==null?void 0:s.faqs)??[];t(u),o(null),a(!1)}).catch(s=>{o(s.message||"Impossible de charger la FAQ"),t([{id:"fallback-1",question:"Où et quand se déroule le festival ?",answer:"Rendez-vous à Campbon (44) les 12 & 13 septembre pour deux jours de musique."},{id:"fallback-2",question:"À quelle heure ouvrent les portes ?",answer:"Nous vous accueillons dès 19h le vendredi et 13h le samedi."}]),a(!1)})},[]),n?e.jsx("section",{className:"py-16 px-6 bg-gray-100",children:e.jsxs("div",{className:"container mx-auto text-center",children:[e.jsx("div",{className:"text-5xl mb-4 drop-shadow-lg",children:"⏳"}),e.jsx("p",{className:"text-white text-lg font-semibold",style:{background:"linear-gradient(to right, #FF0F63, #8F1E98)",WebkitBackgroundClip:"text",WebkitTextFillColor:"transparent",backgroundClip:"text"},children:"Chargement de la FAQ..."})]})}):l?e.jsx("section",{className:"py-16 px-6 bg-gray-100",children:e.jsxs("div",{className:"container mx-auto text-center",children:[e.jsx(w,{className:"text-5xl mb-4 text-red-400 mx-auto"}),e.jsx("p",{className:"text-white text-lg font-semibold",children:l})]})}):e.jsx("section",{className:"py-16 px-6","aria-labelledby":"faq-heading",style:{background:"linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)"},children:e.jsxs("div",{className:"container mx-auto",children:[e.jsx("h2",{id:d,className:"text-4xl font-bold uppercase mb-12 text-left drop-shadow-lg text-white",children:"Foire aux questions"}),e.jsx("p",{id:"faq-desc",className:"sr-only",children:"Réponses aux questions fréquemment posées."}),e.jsx("div",{className:"max-w-2xl mx-auto mt-6 space-y-4",children:r.length>0?e.jsx("ul",{role:"list","aria-label":"Liste des questions fréquentes",children:r.map((s,u)=>{const c=typeof s.id<"u"?s.id:`faq-${u}`,f=`${c}-button`,b=`${c}-panel`;return e.jsx("li",{role:"listitem",className:"mb-3",children:e.jsx(E,{idBase:c,buttonId:f,panelId:b,question:s.question,answer:s.answer})},c)})}):e.jsx("p",{className:"text-white/90",role:"note",children:"Aucune question pour le moment."})})]})})}g.createRoot(document.getElementById("faq-root")).render(e.jsx(j.StrictMode,{children:e.jsx(I,{})}));
