<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Chat To Server</div>
                    <div class="card-body">
                        <alert-error :form="form"></alert-error>
                        <form method="POST">
                            <div class="content">
                                <div class="container-fluid">
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header p-3">
                                                    <h3 class="card-title"> </h3>
                                                    <div class="card-tools float-left">
                                                        <div class="input-group input-group-sm">
                                                            <select v-model="length" @change="getData"
                                                                class="form-control form-control-sm">
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                            </select>
                                                            <button class="btn btn-success btn-sm ml-auto"
                                                                @click="openAddModal" v-if="can('create registrar')"><i
                                                                    class="fas fa-user-plus"></i>
                                                                Add</button>
                                                        </div>
                                                    </div>
                                                    <div class="card-tools">
                                                        <div class="input-group input-group-sm">
                                                            <input v-model="search" type="text" @keyup="getData"
                                                                name="table_search" class="form-control float-right"
                                                                placeholder="Search" />
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-primary"
                                                                    @click="getData">
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
                                                                <th>User Name</th>
                                                                <th>Chat Description</th>
                                                                <th>Send At</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(data, index) in option_chat.data" :key="index">
                                                                <td v-if="data.is_server == null">{{ data.name }}</td>
                                                                <td v-else>Server</td>
                                                                <td>{{ data.description }}</td>
                                                                <td>{{ data.created_at }}</td>
                                                                <!-- <td class="text-right">
                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                @click="openEditModal(data)"><i class="fas fa-eye"></i>
                                                                View</button>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                @click="remove(data.id)"><i
                                                                    class="fas fa-trash-alt"></i> Remove</button>
                                                        </td> -->
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <ul class="pagination pagination-sm m-1 float-right">
                                                        <li class="page-item" v-for="(link, index) in option_chat.links"
                                                            :key="index">
                                                            <button v-html="link.label" @click="getData(link.url)"
                                                                class="page-link"
                                                                :disabled="link.url == null || link.active"
                                                                :class="{ 'text-muted': link.url == null || link.active }">
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!-- declare the add modal -->
                                        <!-- <add-modal @getData="getData"></add-modal> -->
                                        <!-- declare the edit modal -->
                                        <!-- <view-modal @getData="getData" :row="selected_user" :page="current_page"></view-modal> -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Write your chat here</label>
                                <textarea v-model="form.description" type="text" class="form-control"></textarea>
                                <has-error :form="form" field="description" />
                            </div>
                            <button type="button" class="btn btn-primary" @click="create">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            form: new Form({
                description: ''
            }),
            option_chat: '',
            selected_chat: '',
            order_by: '',
            sort_by: 'ASC',
            option_users: [],
            length: 10,
            search: '',
        }
    },
    methods: {
        create() {
            this.form.post('/api/create/chat').then(() => {
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                })
                this.form.reset();
                this.getData();
            }).catch(() => {
                toast.fire({
                    icon: 'error',
                    text: 'Something went wrong!',
                })
            });
        },
        getData(page) {
            if (typeof page === 'undefined' || page.type == 'keyup' || page.type == 'change' || page.type == 'click') {
                page = '/api/chat/user/?page=1';
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
                        section_id: this.section_id
                    },
                })
                    .then(response => {
                        if (response.data.data) {
                            this.option_chat = response.data.data;
                            console.log(this.option_chat);
                        }
                    }).catch(error => {
                        this.error = error;
                        toast.fire({
                            icon: 'error',
                            text: error.response.data.message,
                        })
                    });
            }, 500);
        },
    },
    created() {
        this.getData();
    }
}
</script>
