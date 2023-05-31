<template>
    <div class="modal fade" id="edit-user">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Permission</h5>
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
                    <label>Guard Name</label>
                    <input v-model="form.guard_name" type="text" class="form-control">
                    <has-error :form="form" field="guard_name"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="update">Save changes</button>
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
                    guard_name:'',
                }),
            }
        },
        methods: {
            update(){
                this.form.put('api/permission/update/'+this.form.id).then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    //"page" maintain selected page in the parent page
                    this.$emit('getData', this.page);// call method from parent (reload data table)
                    $('#edit-user').modal('hide');
                }).catch(error =>{
                    toast.fire({
                        icon: 'error',
                        text: error.message+' asdawdas',
                    })
                });
            }
        },
        watch: {
            row: function(){
                this.form.fill(this.row);
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
