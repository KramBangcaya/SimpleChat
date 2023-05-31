<template>
    <div class="modal fade" id="edit-program">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <alert-error :form="form"></alert-error>
                    <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" class="form-control">
                        <has-error :form="form" field="name"/>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input v-model="form.code" type="text" class="form-control">
                        <has-error :form="form" field="code"/>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input v-model="form.email" type="text" class="form-control">
                        <has-error :form="form" field="email"/>
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input v-model="form.category" type="text" class="form-control">
                        <has-error :form="form" field="category"/>
                    </div>
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
        props: {
            row: {required: true},
            page: {required: true},
        },
        data(){
            return{
                form: new Form({
                    id:'',
                    name:'',
                    code:'',
                    email:'',
                    category:'',
                }),
            }
        },
        methods: {
            create(){
                this.form.put('/api/program/update/'+this.form.id).then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    this.form.reset();
                    this.$emit('getData', this.page);
                    $('#edit-program').modal('hide');
                }).catch(()=>{
                    toast.fire({
                        icon: 'error',
                        text: 'Something went wrong!',
                    })
                });
            },
        },
        watch: {
            row: function(){
                this.form.fill(this.row);
            }
        },
    }
</script>

