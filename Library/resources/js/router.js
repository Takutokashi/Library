import {createRouter, createWebHashHistory} from 'vue-router';
import Get from "./components/Get.vue";
import Registration from "./components/Registration.vue";
import login from "./components/Login.vue";
import HomeComponent from "./components/HomeComponent.vue"
import CategoriesComponent from "./components/CategoriesComponent.vue";
import CategoryComponent from "./components/CategoryComponent.vue";
import AuthorizationComponent from "./components/AuthorizationComponent.vue";
import AdminComponent from "./components/AdminComponent.vue";
import ProfileComponent from "./components/ProfileComponent.vue";
import LibrarianComponent from "./components/LibrarianComponent.vue";
import AuthorsComponent from "./components/AuthorsComponent.vue"
import AuthorComponent from "./components/AuthorComponent.vue"
import adminMiddleware from "./middleware/adminMiddleware.js";
import librarianMiddleware from "./middleware/librarianMiddleware.js";



const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: '/get',
            component: Get,
            name: 'get'
        },
        {
            path: '/user/login',
            component: login,
            name: 'login'
        },
        {
            path: '/user/registration',
            component: Registration,
            name: 'registration'
        },
        {
            path: '/home',
            component: HomeComponent,
            name: 'home',
            created() {
                this.$parent.updateButton()
            }
        },
        {
            path: '/categories',
            component: CategoriesComponent,
            name: 'categories'
        },
        {
            path: '/category/:genre',
            component: CategoryComponent,
            name: 'category'
        },
        {
            path: '/authors',
            component: AuthorsComponent,
            name: 'authors'
        },
        {
            path: '/author/:author',
            component: AuthorComponent,
            name: 'author'
        },
        {
            path: '/authorization',
            component: AuthorizationComponent,
            name: 'authorization'
        },
        {
            path: '/admin',
            component: AdminComponent,
            name: 'admin',
            beforeEnter: adminMiddleware,

        },
        {
            path: '/profile',
            component: ProfileComponent,
            name: 'profile'
        },
        {
            path: '/librarian',
            component: LibrarianComponent,
            name: 'librarian',
            beforeEnter: librarianMiddleware,
        },

    ]
})

 export default router;
