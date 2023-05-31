<template>
    <div v-if="!can('list program') && !is('Super-Admin')">
        <forbidden/>
    </div>
    <div v-else>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Program</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Program</a></li>
                            <!-- <li class="breadcrumb-item active">Starter Page</li> -->
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-3">
                            <h3 class="card-title"> </h3>
                            <div class="card-tools float-left">
                                <div class="input-group input-group-sm" >
                                    <select v-model="length" @change="getData" class="form-control form-control-sm w-auto">
                                        <option value="10">Row: 10</option>
                                        <option value="25">Row: 25</option>
                                        <option value="30">Row: 30</option>
                                    </select>
                                    <select v-model="order_by" @change="getData" class="form-control form-control-sm w-auto">
                                        <option value="">Order By</option>
                                        <option value="id">Id</option>
                                        <option value="name">Name</option>
                                        <option value="code">Code</option>
                                        <option value="category">Category</option>
                                        <option value="email">Email</option>
                                        <option value="created_at">Created</option>
                                    </select>
                                    <select v-model="sort_by" @change="getData" class="form-control form-control-sm w-auto">
                                        <option value="ASC">Asc</option>
                                        <option value="DESC">Desc</option>
                                    </select>
                                    <button class="btn btn-success btn-sm ml-auto" @click="openAddModal" v-if="can('create program') || is('Super-Admin')"><i class="fas fa-user-plus"></i> Add</button>
                                </div>
                            </div>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" >
                                    <input
                                        v-model="search" type="text" @keyup="getData"
                                        name="table_search"
                                        class="form-control float-right"
                                        placeholder="Search"
                                    />
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" @click="getData">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Category</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in option_users.data" :key="index">
                                        <td>{{data.id}}</td>
                                        <td>{{data.name}}</td>
                                        <td>{{data.code}}</td>
                                        <td>{{data.category}}</td>
                                        <td>{{data.email}}</td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-primary btn-sm" @click="openEditModal(data)" v-if="can('edit program')"><i class="fas fa-edit"></i> Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm" @click="remove(data.id)" v-if="can('delete program')"><i class="fas fa-trash-alt"></i> Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <ul class="pagination pagination-sm m-1 float-left" v-if="this.option_users.total > 0">
                                <p class="m-1">Showing {{this.option_users.from}} to {{this.option_users.to}} of {{this.option_users.total}} results </p>
                            </ul>
                            <ul class="pagination pagination-sm m-1 float-right">
                                <li class="page-item" v-for="(link, index) in option_users.links" :key="index">
                                    <button v-html="link.label"
                                        @click="getData(link.url)"
                                        class="page-link"
                                        :disabled="link.url == null || link.active"
                                        :class="{'text-muted': link.url == null || link.active}">
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- declare the add modal -->
                <add-modal @getData="getData"></add-modal>
                <!-- declare the edit modal -->
                <edit-modal @getData="getData" :row="selected_user" :page="current_page"></edit-modal>
                </div>
            </div>
        </div>
    </div>
    </template>
    <script>
    import addModal from "./AddProgram.vue";
    import EditModal from "./EditProgram.vue";
    export default {
        components: {
            addModal,
            EditModal,
        },
        data() {
            return {
                order_by:'',
                sort_by:'ASC',
                option_users:[],
                length:10,
                search:'',
                selected_user:[],
                current_page:[],
                form: new Form({
                    id:'',
                }),
                error:'',
            }
        },
        methods: {
            openAddModal() {
                $('#add-program').modal('show');
            },
            openEditModal(data) {
                this.selected_user = data;
                $('#edit-program').modal('show');
            },
            getData(page){
                if (typeof page === 'undefined' || page.type == 'keyup'|| page.type == 'change'|| page.type == 'click') {
                    page = '/api/program/list/?page=1';
                }
                this.current_page = page;
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }
                this.timer = setTimeout(() => {
                    axios.get(page, {
                        params: {
                            search: this.search,
                            length: this.length,
                            time_start: this.time_start,
                            time_end: this.time_end,
                            day: this.day,
                            section_id: this.section_id,
                            order_by: this.order_by,
                            sort_by: this.sort_by,
                        },
                    })
                    .then(response => {
                        if(response.data.data){
                            this.option_users = response.data.data;
                        }
                    }).catch( error =>{
                        this.error = error;
                        toast.fire({
                            icon: 'error',
                            text: error.response.data.message,
                        })
                    });
                }, 500);
            },
            remove(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/api/program/delete/'+id)
                        .then(response => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            this.getData();
                        })
                    }
                }).catch(() =>{

                    toast.fire({
                        icon: 'error',
                        text: 'Something went wrong!',
                    })
                });
            }
        },
        created() {
            this.getData();
        },
    }
    </script>
