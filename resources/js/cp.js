// CP JavaScript entry point for kwijkniet/md-editor addon.

Statamic.booting(function (statamic) {
    statamic.$inertia.register('MdEditor', {
        props: ['actions', 'collection', 'title', 'reference', 'values', 'initialListingUrl', 'itemActionUrl'],

        data() {
            return {
                content: this.values.raw,
            };
        },

        mounted() {
            this._editorStyle = document.createElement('style');
            this._editorStyle.textContent =
                '.md-editor-page .CodeMirror { height: 60vh; }';
            document.head.appendChild(this._editorStyle);
        },

        unmounted() {
            this._editorStyle?.remove();
        },

        methods: {
            async save() {
                try {
                    await this.$axios.patch(this.actions.save, { raw: this.content });
                    this.$toast.success(__('Saved'));
                    this.goBack();
                } catch (e) {
                    this.$toast.error(__('Something went wrong'));
                    console.error(e);
                }
            },
            goBack() {
                this.$inertia.visit(this.actions.editUrl);
            },
        },

        template: `
            <div class="md-editor-page">
                <div class="flex items-center justify-between px-4 py-3 border-b">
                    <h1 class="text-lg font-bold">{{ title }}</h1>
                    <div class="flex gap-2">
                        <ui-button text="Back" @click="goBack" />
                        <ui-button text="Save" variant="primary" @click="save" />
                    </div>
                </div>
                <div class="p-4">
                    <ui-code-editor
                        mode="yaml-frontmatter"
                        :model-value="content"
                        :line-numbers="true"
                        :line-wrapping="true"
                        :allow-mode-selection="false"
                        :show-mode-label="false"
                        indent-type="spaces"
                        :tab-size="2"
                        @update:model-value="content = $event"
                    />
                </div>
            </div>
        `,
    });
});
