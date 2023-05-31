<template>
    <div class="modal fade" id="add-user">
        <div class="modal-dialog model-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <alert-error :form="form"></alert-error>
                    <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" class="form-control">
                        <has-error :form="form" field="name" />
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input v-model="form.email" type="email" class="form-control">
                        <has-error :form="form" field="email" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input v-model="form.password" type="password" class="form-control">
                        <has-error :form="form" field="password" />
                    </div>
                    <!-- <div class="form-group">
                    <label>Role</label>
                    <multiselect v-model="form.role" :options="option_roles" :multiple="false" :close-on-select="true" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true"
                    @input="selectRole">
                    </multiselect>
                    <has-error :form="form" field="guard_name"/>

                </div>
                <div class="form-group">
                    <label>Permission</label>
                    <multiselect v-model="form.permissions" :options="option_permissions" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="name" :preselect-first="true">
                    </multiselect>
                    <has-error :form="form" field="guard_name"/>
                </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="create">Save</button>
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
                name: '',
                email: '',
                password: '',
                role: null,
                permissions: null,
            }),
            option_permissions: [],
            option_roles: [],
        }
    },
    methods: {
        selectRole() {
            this.form.permissions = this.form.role.permissions;
        },
        create() {
            this.form.post('api/user/create').then(() => {
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                })
                this.form.reset();
                this.$emit('getData');// call method from parent
                $('#add-user').modal('hide');
            }).catch(() => {
                toast.fire({
                    icon: 'error',
                    text: 'Something went wrong!',
                })
            });
        },
        loadPermissions() {
            axios.get('/api/permission/all')
                .then(response => {
                    this.option_permissions = response.data.data;
                });
        },
        loadRoles() {
            axios.get('/api/role/all')
                .then(response => {
                    this.option_roles = response.data.data;
                });
        },
    },
    mounted() {
        this.loadPermissions();
        this.loadRoles();
    }
}
</script>
