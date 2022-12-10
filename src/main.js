import { createApp } from 'vue'
import ViewUIPlus from 'view-ui-plus'
import App from './App.vue'
import router from './router'
import store from './store'
import 'view-ui-plus/dist/styles/viewuiplus.css'
// SCSS
import "@/assets/css/app.scss";
// Import Components
import SideBar from "./components/layout/SideBar.vue";
import TheHeader from "./components/layout/Theheader.vue";
import TheHeading from "./components/layout/TheHeading.vue";


const app = createApp(App)

app.use(store)
app.use(router)
app.use(ViewUIPlus)


app.component("side-bar", SideBar);
app.component("the-header", TheHeader);
app.component("the-heading", TheHeading);

app.mount('#app')