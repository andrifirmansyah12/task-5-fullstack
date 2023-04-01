<template>
    <header>
        <div class="nav container">
            <a href="" @click="homePage()" class="logo"
                >Blog <span>Task5</span></a
            >
            <a href="" v-if="currentRouteName" @click="LogoutPage()" class="login">Log Out</a>
            <a href="" v-else @click="loginPage()" class="login">Log In</a>
        </div>
    </header>
</template>

<script>
export default {
    computed: {
        currentRouteName() {
            return this.$route.meta.requiresAuth == true;
        }
    },
    methods: {
        LogoutPage() {
            localStorage.removeItem('token')
            this.$router.push({
                name: "Home",
            });
        },
        loginPage() {
            this.$router.push({
                name: "Login",
            });
        },
        homePage() {
            this.$router.push({
                name: "Home",
            });
        },
    },
};
</script>

<style>
    /* ========================================== LOADER ======================================================= */
    .loader-body {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100vh;
        background: #F8FAFC;
        position: fixed;
        z-index: 999;
        /****** center box
        width: 300px;
        height: 300px;
        border: solid 1px #aaa;
        ******/
    }

    .loader-circle-3 {
        width: 70px;
        height: 70px;
        background: #F8FAFC;
        border-radius: 50%;
        position: relative;
        display: inline-block;
    }

    .loader-circle-3:after,
    .loader-circle-3:before {
        content: "";
        display: block;
        width: 70px;
        height: 70px;
        border-radius: 50%;
    }

    .loader-circle-3::before {
        position: absolute;
        top: 17px;
        left: 17px;
        height: 35px;
        width: 35px;
        background-color: #ff5722;
        animation: loader-circle-3-shrink 3s ease infinite;
    }

    .loader-circle-3::after {
        position: absolute;
        border: 4px solid transparent;
        border-top-color: #00bcd4;
        border-bottom-color: #ff9800;
        top: -4px;
        left: -4px;
        animation: loader-circle-3-spin 2s linear infinite;
    }

    @keyframes loader-circle-3-spin {
        0% {
            transform: rotate(0deg) scale(1);
        }

        50% {
            transform: rotate(180deg) scale(1.2);
        }

        100% {
            transform: rotate(360deg) scale(1);
        }
    }

    @keyframes loader-circle-3-shrink {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.6);
        }

        100% {
            transform: scale(1);
        }
    }
</style>
