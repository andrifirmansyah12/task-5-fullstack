<template>
    <div class="table-heading container">
        <div class="table-container">
            <div class="body-welcome">
                <a href="" class="link-router" @click="Category()">
                    <span class="box-link-router"> Category </span>
                </a>
                <a href="" class="link-router" @click="Article()">
                    <span class="box-link-router"> Article </span>
                </a>
            </div>
            <div class="body-addArticle">
                <h1 class="text-center">Article</h1>
                <button class="button-addArticle" @click="showModalAdd()">
                    <i class="bx bx-plus-medical"></i>
                    <span>Add Article</span>
                </button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Category</th>
                        <th>User</th>
                        <th>Image</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="article in articles" :key="article.id">
                        <td>{{ article.title }}</td>
                        <td>{{ article.content }}</td>
                        <td>{{ article.name_category }}</td>
                        <td>{{ article.name }}</td>
                        <td>
                            <img
                                v-if="article.image"
                                :src="'/img/' + article.image"
                                style="height: 80px; width: 80px"
                            />
                            <img
                                v-else
                                src="/img/ext.jpg"
                                style="height: 80px; width: 80px"
                            />
                        </td>
                        <td>
                            <i
                                class="bx bx-show bx-sm bx-tada-hover"
                                @click="showModalShow(article)"
                            ></i>
                            <i
                                class="bx bx-edit bx-sm bx-tada-hover"
                                @click="showModalEdit(article)"
                            ></i>
                            <i
                                class="bx bx-trash bx-sm bx-tada-hover"
                                @click="handleDeleteArticle(article.id)"
                            ></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <transition
        name="modal-fade"
        v-show="isModalVisibleAdd"
        @close="closeModalAdd()"
    >
        <!-- The Modal -->
        <div id="modal_container" class="modal-container">
            <div class="modal">
                <i
                    class="bx bx-right-arrow-alt bx-md bx-pull-right bx-fw"
                    @click="closeAdd()"
                ></i>
                <h1>Add New Article</h1>
                <form
                    action=""
                    autocomplete="off"
                    @submit.prevent="handleAddArticle"
                    enctype="multipart/form-data"
                >
                    <div class="actual-form">
                        <div class="modal-input-wrap">
                            <input
                                type="text"
                                minlength="4"
                                class="modal-input-field"
                                autocomplete="off"
                                placeholder="Title"
                                name="title"
                                v-model="form.title"
                            />
                        </div>
                        <div class="error" v-if="errors.title">
                            {{ errors.title[0] }}
                        </div>

                        <div class="modal-input-wrap">
                            <input
                                placeholder="Content"
                                type="text"
                                minlength="4"
                                class="modal-input-field"
                                autocomplete="off"
                                name="content"
                                v-model="form.content"
                            />
                        </div>
                        <div class="error" v-if="errors.content">
                            {{ errors.content[0] }}
                        </div>

                        <div class="modal-input-wrap">
                            <select
                                name="category_id"
                                id="category_id"
                                v-model="form.category_id"
                                class="modal-input-field"
                            >
                                <option value="" disabled selected>
                                    Choose Category
                                </option>
                                <option
                                    :value="category.id"
                                    v-for="category in categories"
                                    :key="category.id"
                                >
                                    {{ category.name_category }}
                                </option>
                            </select>
                        </div>
                        <div class="error" v-if="errors.category_id">
                            {{ errors.category_id[0] }}
                        </div>

                        <div class="modal-input-wrap">
                            <input
                                type="file"
                                name="image"
                                @change="uploadPhoto"
                                class="modal-input-field"
                            />
                        </div>
                        <div class="error" v-if="errors.image">
                            {{ errors.image[0] }}
                        </div>
                    </div>
                    <button class="button-form" id="close">Add Category</button>
                </form>
            </div>
        </div>
    </transition>

    <transition
        name="modal-fade"
        v-show="isModalVisibleShow"
        @close="closeModalShow()"
    >
        <!-- The Modal -->
        <div id="modal_container" class="modal-container">
            <div class="modal">
                <i
                    class="bx bx-right-arrow-alt bx-md bx-pull-right bx-fw"
                    @click="closeShow()"
                ></i>
                <h1>Show Article</h1>
                <div class="actual-form">
                    <div class="modal-input-wrap">
                        <input
                            type="text"
                            minlength="4"
                            name="title"
                            class="modal-input-field"
                            autocomplete="off"
                            placeholder="Title"
                            v-model="form.title"
                        />
                    </div>

                    <div class="modal-input-wrap">
                        <textarea
                            readonly
                            name="content"
                            class="modal-textArea-field"
                            cols="30"
                            rows="10"
                            v-model="form.content"
                        ></textarea>
                    </div>

                    <div class="modal-input-wrap">
                        <input
                            readonly
                            placeholder="Category"
                            type="text"
                            minlength="4"
                            class="modal-input-field"
                            autocomplete="off"
                            v-model="form.name_category"
                        />
                    </div>

                    <div class="modal-input-wrap">
                        <img
                            v-if="form.image"
                            :src="'/img/' + form.image"
                            style="height: 80px; width: 80px"
                        />
                        <img
                            v-else
                            src="/img/ext.jpg"
                            style="height: 80px; width: 80px"
                        />
                    </div>
                </div>
            </div>
        </div>
    </transition>

    <transition
        name="modal-fade"
        v-show="isModalVisibleEdit"
        @close="closeModalEdit()"
    >
        <!-- The Modal -->
        <div id="modal_container" class="modal-container">
            <div class="modal">
                <i
                    class="bx bx-right-arrow-alt bx-md bx-pull-right bx-fw"
                    @click="closeEdit()"
                ></i>
                <h1>Edit Category</h1>
                <form
                    action=""
                    autocomplete="off"
                    @submit.prevent="handleUpdateArticle"
                    enctype="multipart/form-data"
                >
                    <div class="actual-form">
                        <div class="modal-input-wrap">
                            <input
                                type="text"
                                minlength="4"
                                class="modal-input-field"
                                autocomplete="off"
                                placeholder="Title"
                                v-model="form.title"
                                name="title"
                            />
                        </div>
                        <div class="error" v-if="errors.title">
                            {{ errors.title[0] }}
                        </div>

                        <div class="modal-input-wrap">
                            <input
                                placeholder="Content"
                                type="text"
                                minlength="4"
                                class="modal-input-field"
                                autocomplete="off"
                                v-model="form.content"
                                name="content"
                            />
                        </div>
                        <div class="error" v-if="errors.content">
                            {{ errors.content[0] }}
                        </div>

                        <div class="modal-input-wrap">
                            <select
                                name="category_id"
                                id="category_id"
                                v-model="form.category_id"
                                class="modal-input-field"
                            >
                                <option disabled>Choose Category</option>
                                <option
                                    :value="category.id"
                                    v-for="category in categories"
                                    :key="category.id"
                                >
                                    {{ category.name_category }}
                                </option>
                            </select>
                        </div>
                        <div class="error" v-if="errors.category_id">
                            {{ errors.category_id[0] }}
                        </div>

                        <img
                            v-if="form.image"
                            :src="'/img/' + form.image"
                            style="height: 80px; width: 80px"
                        />
                        <img
                            v-else
                            src="/img/ext.jpg"
                            style="height: 80px; width: 80px"
                        />
                        <div class="modal-input-wrap">
                            <input
                                type="file"
                                name="image"
                                @change="uploadPhoto"
                                class="modal-input-field"
                            />
                        </div>
                        <div class="error" v-if="errors.image">
                            {{ errors.image[0] }}
                        </div>
                    </div>
                    <button class="button-form" id="close">
                        Edit Category
                    </button>
                </form>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    data: () => {
        return {
            form: {
                title: "",
                content: "",
                category_id: "",
                image: "",
            },
            errors: {},
            logeddIn: [],
            articles: [],
            categories: [],
            isModalVisibleAdd: false,
            isModalVisibleEdit: false,
            isModalVisibleShow: false,
        };
    },
    mounted() {
        this.getUsers();
        this.getArticles();
        this.getCategories();
    },
    methods: {
        // Add Modal
        showModalAdd() {
            this.isModalVisibleAdd = true;
        },
        closeModalAdd() {
            this.isModalVisibleAdd = false;
        },
        closeAdd() {
            this.isModalVisibleAdd = false;
            this.form.image = null
        },
        // Show Modal
        showModalShow(articles) {
            this.isModalVisibleShow = true;
            this.form = articles;
        },
        closeModalShow() {
            this.isModalVisibleShow = false;
        },
        closeShow() {
            this.isModalVisibleShow = false;
        },
        // Edit Modal
        showModalEdit(articles) {
            this.isModalVisibleEdit = true;
            this.form = articles;
        },
        closeModalEdit() {
            this.isModalVisibleEdit = false;
        },
        closeEdit() {
            this.isModalVisibleEdit = false;
        },
        getUsers() {
            axios.get("/api/user").then((response) => {
                this.logeddIn = response.data;
            });
        },
        getArticles() {
            axios.get("/api/article").then((response) => {
                this.articles = response.data;
            });
        },
        getCategories() {
            axios.get("/api/category").then((response) => {
                this.categories = response.data;
            });
        },
        uploadPhoto(e) {
            this.form.image = e.target.files[0];
        },
        handleAddArticle(e) {
            e.preventDefault();
            const config = {
                headers: { "content-type": "multipart/form-data" },
            };
            let formData = new FormData();
            formData.append("image", this.form.image);
            formData.append("title", this.form.title);
            formData.append("content", this.form.content);
            formData.append("category_id", this.form.category_id);
            axios
                .post("/api/article/store", formData, config)
                .then((response) => {
                    if (response.data.success) {
                        this.getArticles();
                        this.closeAdd();
                    }
                })
                .catch((error) => {
                    if (error.response.data.success == false) {
                        this.errors = error.response.data.message;
                    }
                });
        },
        handleUpdateArticle(e) {
            e.preventDefault();
            const config = {
                headers: { "content-type": "multipart/form-data" },
            };
            let formData = new FormData();
            formData.append("image", this.form.image);
            formData.append("title", this.form.title);
            formData.append("content", this.form.content);
            formData.append("category_id", this.form.category_id);
            axios
                .post("/api/article/update/" + this.form.id, formData, config)
                .then((response) => {
                    if (response.data.success) {
                        this.getArticles();
                        this.closeEdit();
                    }
                })
                .catch((error) => {
                    if (error.response.data.success == false) {
                        this.errors = error.response.data.message;
                    }
                });
        },
        handleDeleteArticle(id) {
            if (confirm("Apakah ingin dihapus?")) {
                axios.delete("/api/article/delete/" + id).then((response) => {
                    if (response.data.success) {
                        this.getArticles();
                    }
                });
            } else {
                return false;
            }
        },
        Category() {
            this.$router.push({
                name: "Category",
            });
        },
        Article() {
            this.$router.push({
                name: "Article",
            });
        },
    },
};
</script>

<style>
/* CSS STYLE */
.image-preview {
    width: 100px;
    padding: 10px;
}

.box-link-router {
    width: 140px;
    height: auto;
    float: left;
    transition: 0.5s linear;
    position: relative;
    display: block;
    overflow: hidden;
    padding: 15px;
    text-align: center;
    margin: 0 5px;
    background: transparent;
    text-transform: uppercase;
    font-weight: 900;
}

.box-link-router:before {
    position: absolute;
    content: "";
    left: 0;
    bottom: 0;
    height: 4px;
    width: 100%;
    border-bottom: 4px solid transparent;
    border-left: 4px solid transparent;
    box-sizing: border-box;
    transform: translateX(100%);
}

.box-link-router:after {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    border-top: 4px solid transparent;
    border-right: 4px solid transparent;
    box-sizing: border-box;
    transform: translateX(-100%);
}

.box-link-router:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
}

.box-link-router:hover:before {
    border-color: #262626;
    height: 100%;
    transform: translateX(0);
    transition: 0.3s transform linear, 0.3s height linear 0.3s;
}

.box-link-router:hover:after {
    border-color: #262626;
    height: 100%;
    transform: translateX(0);
    transition: 0.3s transform linear, 0.3s height linear 0.5s;
}

.link-router {
    color: black;
    text-decoration: none;
    cursor: pointer;
    outline: none;
    border: none;
    background: transparent;
}

.button-addArticle {
    display: flex;
    height: 3em;
    width: 150px;
    align-items: center;
    justify-content: center;
    background-color: #eeeeee4b;
    border-radius: 3px;
    color: white;
    letter-spacing: 1px;
    transition: all 0.2s linear;
    cursor: pointer;
    border: none;
    background: blue;
}

.button-addArticle > i {
    margin-right: 5px;
    margin-left: 5px;
    font-size: 20px;
    transition: all 0.4s ease-in;
}

.button-addArticle:hover > i {
    font-size: 1.2em;
    transform: translateX(-5px);
}

.button-addArticle:hover {
    box-shadow: 9px 9px 33px #d1d1d1, -9px -9px 33px #ffffff;
    transform: translateY(-2px);
}

.body-welcome {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-bottom: 30px;
    align-items: center;
    color: black;
}

.text-welcome {
    padding-bottom: 30px;
}

.body-addArticle {
    display: flex;
    align-items: center;
    justify-content: space-around;
    margin-bottom: 30px;
}

/* ========================================================== Table ============================================ */

.table-heading {
    margin-top: 8rem;
    margin-bottom: 8rem;
}
table {
    width: 100%;
    margin: auto;
    font-family: "Arial";
    font-size: 12px;
}
.text-center {
    text-align: center;
}
.table {
    border-collapse: collapse;
    font-size: 13px;
}
.table th,
.table td {
    border-bottom: 1px solid #cccccc;
    border-left: 1px solid #cccccc;
    padding: 9px 21px;
}
.table th,
.table td:last-child {
    border-right: 1px solid #cccccc;
}
.table td:first-child {
    border-top: 1px solid #cccccc;
}
caption {
    caption-side: top;
    margin-bottom: 10px;
    font-size: 16px;
}

/* Table Header */
.table thead th {
    background-color: #2ecd71;
    color: #ffffff;
}

/* Table Body */
.table tbody td {
    color: #353535;
}
.table tbody tr:nth-child(odd) td {
    background-color: #f5fff9;
}
.table tbody tr:hover th,
.table tbody tr:hover td {
    background-color: #f0f0f0;
    transition: all 0.2s;
}

/*Tabel Responsive 1*/
.table-container {
    overflow: auto;
}

/* =================================================== Modal Form ============================================== */

.bx {
    cursor: pointer;
}

.button-form {
    background-color: #47a386;
    border: 0;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    color: #fff;
    font-size: 14px;
    padding: 10px 25px;
    cursor: pointer;
}

.modal-container {
    z-index: 999;
    display: flex;
    background-color: rgba(0, 0, 0, 0.3);
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100vw;
    transition: opacity 0.3s ease;
}

.modal {
    background-color: #fff;
    width: 600px;
    max-width: 100%;
    padding: 30px 50px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.modal h1 {
    margin: 0;
    padding-bottom: 30px;
    text-align: start;
}

.modal p {
    opacity: 0.7;
    font-size: 14px;
}

.modal-fade-enter,
.modal-fade-leave-to {
    opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.5s ease;
}

.modal-textArea-field {
    width: 100%;
    height: 100%;
    background: none;
    border: none;
    outline: none;
    border-bottom: 1px solid #bbb;
    padding: 0;
    font-size: 0.95rem;
    color: #151111;
    transition: 0.4s;
}

.modal-input-field {
    width: 100%;
    height: 100%;
    background: none;
    border: none;
    outline: none;
    border-bottom: 1px solid #bbb;
    padding: 0;
    font-size: 0.95rem;
    color: #151111;
    transition: 0.4s;
}

.modal-input-wrap {
    position: relative;
    height: 37px;
    margin-bottom: 2rem;
}
</style>
