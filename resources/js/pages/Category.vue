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
            <div class="body-addCategory">
                <h1 class="text-center">CATEGORY</h1>
                <button class="button-addCategory" @click="showModalAdd()">
                    <i class="bx bx-plus-medical"></i>
                    <span>Add Category</span>
                </button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>User</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories" :key="category.id">
                        <td>{{ category.name_category }}</td>
                        <td>{{ category.name }}</td>
                        <td>
                            <i
                                class="bx bx-show bx-sm bx-tada-hover"
                                @click.prevent="showModalShow(category)"
                            ></i>
                            <i
                                class="bx bx-edit bx-sm bx-tada-hover"
                                @click.prevent="showModalEdit(category)"
                            ></i>
                            <i
                                class="bx bx-trash bx-sm bx-tada-hover"
                                @click.prevent="handleDeleteCategory(category.id)"
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
                <h1>Add New Category</h1>
                <form
                    action=""
                    autocomplete="off"
                    @submit.prevent="handleAddCategory"
                >
                    <div class="actual-form">
                        <div class="modal-input-wrap">
                            <input
                                type="text"
                                class="modal-input-field"
                                autocomplete="off"
                                placeholder="Category Name"
                                v-model="form.name_category"
                            />
                        </div>
                        <div class="error" v-if="errors.name_category">
                            {{ errors.name_category[0] }}
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
                <h1>Show Category</h1>
                <form action="" autocomplete="off">
                    <div class="actual-form">
                        <div class="modal-input-wrap">
                            <input
                                type="text"
                                minlength="4"
                                readonly
                                class="modal-input-field"
                                autocomplete="off"
                                placeholder="Category Name"
                                v-model="form.name_category"
                            />
                        </div>
                    </div>
                </form>
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
                    @submit.prevent="handleUpdateCategory"
                >
                    <div class="actual-form">
                        <div class="modal-input-wrap">
                            <input
                                type="text"
                                minlength="4"
                                class="modal-input-field"
                                autocomplete="off"
                                placeholder="Category Name"
                                v-model="form.name_category"
                            />
                        </div>
                        <div class="error" v-if="errors.name_category">
                            {{ errors.name_category[0] }}
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
                name_category: "",
            },
            errors: {},
            logeddIn: [],
            categories: [],
            isModalVisibleAdd: false,
            isModalVisibleEdit: false,
            isModalVisibleShow: false,
        };
    },
    mounted() {
        this.getUsers();
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
            this.form = '';
        },
        // Show Modal
        showModalShow(categories) {
            this.isModalVisibleShow = true;
            this.form = categories;
        },
        closeModalShow() {
            this.isModalVisibleShow = false;
        },
        closeShow() {
            this.isModalVisibleShow = false;
        },
        // Edit Modal
        showModalEdit(categories) {
            this.isModalVisibleEdit = true;
            this.form = categories;
        },
        closeModalEdit() {
            this.isModalVisibleEdit = false;
            this.form = '';
        },
        closeEdit() {
            this.isModalVisibleEdit = false;
            this.form = '';
        },
        getUsers() {
            axios.get("/api/user").then((response) => {
                this.logeddIn = response.data;
            });
        },
        getCategories() {
            axios.get("/api/category").then((response) => {
                this.categories = response.data;
            });
        },
        handleAddCategory() {
            axios
                .post("/api/category/store", this.form)
                .then((response) => {
                    if (response.data.success) {
                        this.getCategories();
                        this.closeAdd();
                    }
                })
                .catch((error) => {
                    if (error.response.data.success == false) {
                        this.errors = error.response.data.message;
                    }
                });
        },
        handleUpdateCategory() {
            axios
                .post("/api/category/update/" + this.form.id, this.form)
                .then((response) => {
                    if (response.data.success) {
                        this.getCategories();
                        this.closeEdit();
                    }
                })
                .catch((error) => {
                    if (error.response.data.success == false) {
                        this.errors = error.response.data.message;
                    }
                });
        },
        handleDeleteCategory(id) {
            if (confirm("Apakah ingin dihapus?")) {
                axios
                    .delete("/api/category/delete/" + id)
                    .then((response) => {
                        if (response.data.success) {
                            this.getCategories();
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

.button-addCategory {
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

.button-addCategory > i {
    margin-right: 5px;
    margin-left: 5px;
    font-size: 20px;
    transition: all 0.4s ease-in;
}

.button-addCategory:hover > i {
    font-size: 1.2em;
    transform: translateX(-5px);
}

.button-addCategory:hover {
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

.body-addCategory {
    display: flex;
    align-items: center;
    justify-content: space-around;
    margin-bottom: 30px;
}

/* ============================================================ Form =========================================== */

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

/* ===================================================== Form ================================================ */

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
