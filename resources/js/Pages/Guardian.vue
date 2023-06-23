<script>

export default {
    components: {
    },
    props:['guardian','members'],
    data() {
        return{
        }
    }
}

</script>

<template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <ol>
                        <li v-for="member in members">
                            <inertia-link :href="route('guardian.actAs',member)">{{ member.first_name }}</inertia-link>
                            
                        </li>
                    </ol>
                </div>
            </div>
        </div>
</template>

