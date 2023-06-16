<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row card-body">
                        <alert-error :form="form"></alert-error>
                        <div class="col-8">
                            <section id="section-chat"
                                class="d-flex flex-col justify-between align-center card mx-auto h-80 hide">
                                <nav id="nav-online" class="w-100 d-flex">
                                    <h3 class="white pl-1">Group Chat </h3>
                                    <div id="avatars">
                                    </div>
                                </nav>
                                <li id="list-messages" class="px-1 d-flex flex-col">
                                </li>
                            </section>
                            <div class="form-group">
                                <label>Write your chat here</label>
                                <textarea v-model="form.description" type="text" class="form-control"></textarea>
                                <has-error :form="form" field="description" />
                            </div>
                            <button type="button" class="btn btn-primary" @click="create">Send</button>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">Active User</div>
                                <div class="card-body">
                                    <li v-for="user in usersOnline">
                                        {{ user.name }}
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="isLoading" class="loading-screen">
            Loading...
        </div>
    </div>
</template>
<style>
.loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    color: #fff;
    font-size: 20px;
}

#list-messages>li {
    background-color: #d1e7ff;
    padding: 0.5rem 1rem 0.5rem 1rem;
    border-radius: 8px;
    margin-top: 5px;
    margin-bottom: 5px;
    max-width: 70%;
    width: fit-content;
}

.message-author {
    color: rgb(29, 117, 218);
    font-size: 0.85rem;
    font-weight: bold;
}

.avatar {
    position: relative;
    top: 20px;
    left: 5px;
    border-radius: 50%;
    background-color: rgb(255, 196, 118);
    border-style: solid;
    border-width: 0px;
    font-size: 0.8rem;
    padding: 0.75rem;
}

#nav-online {
    box-shadow: 3px 4px 10px grey;
    background-color: rgb(76, 155, 245);
    height: 58px;
}

.d-flex {
    display: flex;
}

.flex-col {
    flex-direction: column;
}
</style>

<script>

export default {
    data() {
        return {
            form: new Form({
                description: ''
            }),
            isLoading: false,
            usersOnline: [],
        }
    },
    methods: {
        create() {
            this.isLoading = true;
            this.form.post('/api/create/groupchat').then(() => {
                toast.fire({
                    icon: 'success',
                    text: 'Successfully Send.'
                })
                this.form.reset();
                this.isLoading = false;
            }).catch(() => {
                toast.fire({
                    icon: 'error',
                    text: 'Something went wrong!',
                })
                this.isLoading = false;
            });
        },
        addChatMessage(name, message, color = "black") {
            const li = document.createElement('li');

            const listMessage = document.getElementById('list-messages');

            li.classList.add('d-flex', 'flex-col');

            const span = document.createElement('span')
            span.classList.add('message-author');
            span.textContent = name;

            const messageSpan = document.createElement('span');
            messageSpan.textContent = message;

            messageSpan.style.color = color;

            li.append(span, messageSpan);

            listMessage.append(li);
        },
        renderAvatars() {
            avatars.textContent = "";

            this.usersOnline.forEach((user) => {
                const span = document.createElement('span');
                span.textContent = this.userInitial(user.name);
                span.classList.add('avatar');
                avatars.append(span);
            })
        },
        userInitial(username) {
            const names = username.split(' ');
            return names.map((name) => name[0]).join("").toUpperCase();
        }
    },
    created() {
        //Presence Channel    
        Echo.join('presence.chat.1')
            .here((users) => {
                this.usersOnline = [...users];
                this.renderAvatars();
            })
            .joining((user) => {
                this.usersOnline.push(user);
                this.renderAvatars();
                this.addChatMessage(user.name, "has joined the room!");
            })
            .leaving((user) => {
                this.usersOnline = this.usersOnline.filter((userOnline) => userOnline.id !== user.id);
                this.renderAvatars();
                this.addChatMessage(user.name, "has left the room.", 'grey');
            })
            .listen('.activeUser', (event) => {
                const message = event.message;
                this.addChatMessage(event.user.name, message);
            })
    },
}
</script>
