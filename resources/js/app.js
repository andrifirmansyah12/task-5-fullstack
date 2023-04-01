/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import "./bootstrap";
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";

import Template from "./template/Index.vue";

import Home from "./pages/Home.vue";
import NotFound from "./error/NotFound.vue";
import Login from "./auth/Login.vue";
import Register from "./auth/Register.vue";
import Email from "./auth/password/Email.vue";
import Reset from "./auth/password/Reset.vue";
import Category from "./pages/Category.vue";
import Article from "./pages/Article.vue";

const routes = [
    {
        path: "/:pathMatch(.*)*",
        component: NotFound,
        meta: {
            requiresAuth: false
        }
    },
    {
        name: "Home",
        path: "/",
        component: Home,
        meta: {
            requiresAuth: false
        }
    },
    {
        name: "Login",
        path: "/login",
        component: Login,
        meta: {
            requiresAuth: false
        }
    },
    {
        name: "Register",
        path: "/register",
        component: Register,
        meta: {
            requiresAuth: false
        }
    },
    {
        name: "Email",
        path: "/password/email",
        component: Email,
        meta: {
            requiresAuth: false
        }
    },
    {
        name: "Reset",
        path: "/password/reset/:token",
        component: Reset,
    },
    {
        name: "Category",
        path: "/category",
        component: Category,
        meta: {
            requiresAuth: true
        }
    },
    {
        name: "Article",
        path: "/article",
        component: Article,
        meta: {
            requiresAuth: true
        }
    },
];

const router = new createRouter({
    routes,
    history: createWebHistory(),
});

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !localStorage.getItem('token')) {
        return { name: 'Login' }
    }

    if (to.meta.requiresAuth == false && localStorage.getItem('token')) {
        return { name: 'Category' }
    }
})

const app = createApp(Template);

app.use(router);

app.mount("#app");

// ===========================================================================================================

// nav background
let header = document.querySelector("header");

window.addEventListener("scroll", () => {
    header.classList.toggle("shadow", window.scrollY > 0)
})

//Filter
$(document).ready(function () {
    $(".filter-item").click(function () {
        const value = $(this).attr("data-filter");
        if (value == "all"){
            $(".post-box").show("1000")
        } else{
            $(".post-box")
                .not("." + value)
                .hide(1000);
            $(".post-box")
            .filter("." + value)
            .show("1000")
        }
    });
    $(".filter-item").click(function () {
        $(this).addClass("active-filter").siblings().removeClass("active-filter")
    });
});


// ============================================================ Login ==============================================================

const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });
});

toggle_btn.forEach((btn) => {
  btn.addEventListener("click", () => {
    main.classList.toggle("sign-up-mode");
  });
});

function moveSlider() {
  let index = this.dataset.value;

  let currentImage = document.querySelector(`.img-${index}`);
  images.forEach((img) => img.classList.remove("show"));
  currentImage.classList.add("show");

  const textSlider = document.querySelector(".text-group");
  textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

  bullets.forEach((bull) => bull.classList.remove("active"));
  this.classList.add("active");
}

bullets.forEach((bullet) => {
  bullet.addEventListener("click", moveSlider);
});
