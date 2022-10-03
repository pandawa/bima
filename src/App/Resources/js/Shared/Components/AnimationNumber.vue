<template>
{{ displayNumber }}
</template>

<script>
export default {
    props: {
        number: {
            default: 0,
        },
    },
    data() {
        return {
            displayNumber: 0,
            interval: false,
        };
    },
    mounted() {
        this.displayNumber = this.number ? this.number : 0;
    },
    watch: {
        number() {
            clearInterval(this.interval);

            if(this.number === this.displayNumber){
                return;
            }

            this.interval = setInterval(() => {
                if (this.displayNumber !== this.number) {
                    let change = (this.number - this.displayNumber) / 10;

                    change = change >= 0 ? Math.ceil(change) : Math.floor(change);

                    this.displayNumber = this.displayNumber + change;
                }
            }, 50);
        }
    }
}
</script>
