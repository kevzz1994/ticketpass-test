<template>
    <div>
        <b-message v-if="flash.warning" title="Notice" type="is-warning" aria-close-label="Close message">
            {{flash.warning}}
        </b-message>
        <pre>{{ $page.auth.user }}</pre>
    </div>
</template>

<script>
/* Layout */
import Layout from '@/layouts/General';

export default {
    layout: Layout,
    props: {
        flash: Object
    }
}
</script>
