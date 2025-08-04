<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component. {{ name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "ExampleComponent",
    data() {
        return {
            name: "amit",
        };
    },
    async mounted() {
        try {
            const response = await axios.get('http://avghealthcare.test:8000/api/test');
            this.name=response.data;
            console.log(response.data);

            // If you want to update 'name' with API response
            // this.name = response.data.name;
        } catch (error) {
            console.error("API fetch error:", error);
        }

        console.log('Component mounted.');
    }
};
</script>
