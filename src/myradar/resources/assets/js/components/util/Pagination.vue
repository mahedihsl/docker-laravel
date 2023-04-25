<template>
    <ul class="pagination">
        <li v-bind:class="{disabled: pagination.current_page < 2}">
            <a href="#" aria-label="Previous" v-on:click.prevent="changePage(pagination.current_page - 1)">
                <span aria-hidden="true">«</span>
            </a>
        </li>
        <li v-for="page in pagesNumber" :class="{'active': page == pagination.current_page}" :key="page">
            <a href="#" v-on:click.prevent="changePage(page)">{{ page }}</a>
        </li>
        <li v-bind:class="{disabled: pagination.current_page == pagination.total_pages}">
            <a href="#" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1)">
                <span aria-hidden="true">»</span>
            </a>
        </li>
    </ul>
</template>
<script>
export default{
    props: {
        pagination: {
            type: Object,
            required: true
        },
        offset: {
            type: Number,
            default: 4
        }
    },
    computed: {
        pagesNumber: function () {
            // if (!this.pagination.to) {
            //     return [];
            // }
            let from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            let to = from + (this.offset * 2);
            if (to >= this.pagination.total_pages) {
                to = this.pagination.total_pages;
            }
            let pagesArray = [];
            for (from = 1; from <= to; from++) {
                pagesArray.push(from);
            }
            return pagesArray;
        }
    },
    methods : {
        changePage(page) {
            console.log(`inside changePage`, page)
            
            if (page < 1 || page > this.pagination.total_pages) {
                return;
            }

            this.pagination.current_page = page;

            this.$emit('pageChanged', +page)
        }
    }
}
</script>
