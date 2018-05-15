<template>

	<tr>
		<td>{{this.user.fname}}</td>
		<td>Hi</td>
		<td></td>
		<td></td>
	</tr>

</template>

<script>
    export default {
        mounted() {
            console.log(this.user)
        },

        props: [
        	'user'
        ],

    }

</script>
