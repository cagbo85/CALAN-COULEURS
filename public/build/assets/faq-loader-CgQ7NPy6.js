import{r as l,j as e,R as g,a as j}from"./client-CU1SI9-t.js";import{B as w}from"./index-CMmoeHmW.js";/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y=r=>r.replace(/([a-z0-9])([A-Z])/g,"$1-$2").toLowerCase(),v=r=>r.replace(/^([A-Z])|[\s-_]+(\w)/g,(s,n,o)=>o?o.toUpperCase():n.toLowerCase()),x=r=>{const s=v(r);return s.charAt(0).toUpperCase()+s.slice(1)},h=(...r)=>r.filter((s,n,o)=>!!s&&s.trim()!==""&&o.indexOf(s)===n).join(" ").trim();/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */var C={xmlns:"http://www.w3.org/2000/svg",width:24,height:24,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor",strokeWidth:2,strokeLinecap:"round",strokeLinejoin:"round"};/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const N=l.forwardRef(({color:r="currentColor",size:s=24,strokeWidth:n=2,absoluteStrokeWidth:o,className:i="",children:a,iconNode:m,...d},t)=>l.createElement("svg",{ref:t,...C,width:s,height:s,stroke:r,strokeWidth:o?Number(n)*24/Number(s):n,className:h("lucide",i),...d},[...m.map(([u,c])=>l.createElement(u,c)),...Array.isArray(a)?a:[a]]));/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f=(r,s)=>{const n=l.forwardRef(({className:o,...i},a)=>l.createElement(N,{ref:a,iconNode:s,className:h(`lucide-${y(x(r))}`,`lucide-${r}`,o),...i}));return n.displayName=x(r),n};/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const k=[["path",{d:"m6 9 6 6 6-6",key:"qrunsl"}]],q=f("chevron-down",k);/**
 * @license lucide-react v0.487.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const F=[["path",{d:"m18 15-6-6-6 6",key:"153udz"}]],E=f("chevron-up",F);function A({idBase:r,buttonId:s,panelId:n,question:o,answer:i}){const[a,m]=l.useState(!1),d=()=>m(t=>!t);return e.jsxs("div",{className:"bg-white/10 backdrop-blur-md rounded-md text-white px-4 py-3",style:{background:"linear-gradient(90deg, #1d3f89 0%, #77cbf3 100%)"},"data-open":a?"true":"false",children:[e.jsx("h3",{className:"m-0",children:e.jsxs("button",{id:s,type:"button",onClick:d,"aria-expanded":a,"aria-controls":n,className:"w-full flex justify-between items-center font-semibold uppercase text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-[#8F1E98] rounded-md py-1",children:[e.jsx("span",{children:o}),e.jsx("span",{"aria-hidden":"true",className:"ml-2",children:a?e.jsx(E,{size:18,"aria-hidden":"true",focusable:"false"}):e.jsx(q,{size:18,"aria-hidden":"true",focusable:"false"})})]})}),e.jsx("div",{id:n,role:"region","aria-labelledby":s,hidden:!a,className:"mt-2 text-sm text-white/80",children:e.jsx("p",{children:i})})]})}function I(){const[r,s]=l.useState([]),[n,o]=l.useState(!0),[i,a]=l.useState(null),d="faq-heading";return l.useEffect(()=>{fetch("/api/faqs").then(t=>{if(!t.ok)throw new Error("Impossible de charger la FAQ");return t.json()}).then(t=>{const u=Array.isArray(t)?t:(t==null?void 0:t.faqs)??[];s(u),a(null),o(!1)}).catch(t=>{a(t.message||"Impossible de charger la FAQ"),s([{id:"fallback-1",question:"Où et quand se déroule le festival ?",answer:"Rendez-vous à Campbon (44) les 26 & 27 juin pour deux jours de musique."},{id:"fallback-2",question:"À quelle heure ouvrent les portes ?",answer:"Nous vous accueillons dès 19h le vendredi et 13h le samedi."}]),o(!1)})},[]),n?e.jsx("section",{className:"px-6 py-16",style:{backgroundColor:"#EEF1FF"},children:e.jsxs("div",{className:"container mx-auto text-center",children:[e.jsx("div",{className:"mb-4 text-5xl drop-shadow-lg",children:"⏳"}),e.jsx("p",{className:"text-lg font-semibold text-[#1d3f89]",children:"Chargement de la FAQ..."})]})}):i?e.jsx("section",{className:"px-6 py-16",style:{backgroundColor:"#EEF1FF"},children:e.jsxs("div",{className:"container mx-auto text-center",children:[e.jsx(w,{className:"mx-auto mb-4 text-5xl text-red-400"}),e.jsx("p",{className:"text-lg font-semibold text-[#1d3f89]",children:i})]})}):e.jsx("section",{className:"px-6 py-16",style:{backgroundColor:"#EEF1FF"},"aria-labelledby":"faq-heading",children:e.jsxs("div",{className:"container mx-auto",children:[e.jsx("h2",{id:d,className:"mb-12 text-4xl font-bold text-left uppercase drop-shadow-lg",style:{background:"linear-gradient(180deg, #1d3f89 0%, #77cbf3 100%)",WebkitBackgroundClip:"text",WebkitTextFillColor:"transparent",backgroundClip:"text"},children:"Foire aux questions"}),e.jsx("p",{id:"faq-desc",className:"sr-only",children:"Réponses aux questions fréquemment posées."}),e.jsx("div",{className:"max-w-6xl mx-auto mt-6 space-y-4",children:r.length>0?e.jsx("ul",{role:"list","aria-label":"Liste des questions fréquentes",children:r.map((t,u)=>{const c=typeof t.id<"u"?t.id:`faq-${u}`,p=`${c}-button`,b=`${c}-panel`;return e.jsx("li",{role:"listitem",className:"mb-3",children:e.jsx(A,{idBase:c,buttonId:p,panelId:b,question:t.question,answer:t.answer})},c)})}):e.jsx("p",{className:"text-[#1d3f89]/90",role:"note",children:"Aucune question pour le moment."})})]})})}g.createRoot(document.getElementById("faq-root")).render(e.jsx(j.StrictMode,{children:e.jsx(I,{})}));
