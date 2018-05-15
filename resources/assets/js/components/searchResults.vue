<template>


	<table id="memberTable">
		<thead>
			<tr>
				<th><!-- img --></th>
				<th>Name</th>
				<th>Address</th>
				<th>Postcode</th>
				<th></th>
			</tr>
		</thead>
		<tbody>

			<member-row v-for="user in this.memberstodisplay" :user="user" :key="user.id"></member-row>

		</tbody>
	</table>


</template>

<script>
    export default {
        mounted() {
            console.log(this.memberstodisplay)
        },

        props: [
        	'memberstodisplay'
        ]

    }

</script>
