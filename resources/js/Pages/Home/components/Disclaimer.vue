<template>
    <v-dialog v-model="dialog" max-width="1000" title="Disclaimer">
        <template #activator>
            <div
                class="cursor-pointer hover:text-slate-200"
                @click="dialog = true"
            >
                Disclaimer
            </div>
        </template>

        <div class="space-y-5 p-8">
            <p>
                The information provided on this website is for general
                informational purposes only. While we make every effort to
                ensure the accuracy of the information on our website, we make
                no representations or warranties of any kind, express or
                implied, about the completeness, accuracy, reliability,
                suitability, or availability with respect to the website or the
                information, products, services, or related graphics contained
                on the website for any purpose. Any reliance you place on such
                information is therefore strictly at your own risk.
            </p>
            <p>
                In no event will we be liable for any loss or damage including
                without limitation, indirect or consequential loss or damage, or
                any loss or damage whatsoever arising from loss of data or
                profits arising out of, or in connection with, the use of this
                website.
            </p>
            <p>
                Through this website you can link to other websites which are
                not under our control. We have no control over the nature,
                content, and availability of those sites. The inclusion of any
                links does not necessarily imply a recommendation or endorse the
                views expressed within them.
            </p>
            <p>
                Every effort is made to keep the website up and running
                smoothly. However, we take no responsibility for, and will not
                be liable for, the website being temporarily unavailable due to
                technical issues beyond our control.
            </p>
            <p>
                We reserve the right to modify or update this disclaimer at any
                time without prior notice. Any changes to this disclaimer will
                be posted on our website.
            </p>
            <p>
                If you have any questions or concerns about this disclaimer or
                the way we provide information on our website, please contact
                us.
            </p>
        </div>
    </v-dialog>
</template>

<script setup>
import { ref } from "vue";

const dialog = ref(false);
</script>

<style lang="scss" scoped></style>
