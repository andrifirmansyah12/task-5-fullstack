<template>
    <div>
        <section class="home" id="home">
            <div class="home-text container">
                <h2 class="home-title">Ini Blogku</h2>
                <span class="home-subtitle">Task 5 Fullstack.</span>
            </div>
        </section>

        <div class="post container">
            <!-- Post 1 -->
            <div class="post-box tech" v-for="article in articles" :key="article.id">
                <img v-if="article.image" :src="'/img/' + article.image" alt="" class="post-img">
                <img v-else src="/img/ext.jpg" alt="" class="post-img">
                <h2 class="category">{{ article.name_category }}</h2>
                <a href="#" class="post-title">{{ article.title }}</a>
                <span class="post-date">{{ formattedDate }}</span>
                <p class="post-description">{{ article.content }}.</p>
                <div class="profile">
                    <img src="/img/ext.jpg" alt="" class="profile-img">
                    <span class="profile-name">{{ article.name }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        data: () => {
            return {
                articles: [],
            };
        },
        mounted() {
            this.getArticles();
        },
        computed: {
            formattedDate() {
                return moment(this.articles.created_at).format('DD-MM-YYYY');
            }
        },
        methods: {
            getArticles() {
                axios.get("/api/home").then((response) => {
                    this.articles = response.data;
                });
            },
        }
    }
</script>

<style>

</style>
