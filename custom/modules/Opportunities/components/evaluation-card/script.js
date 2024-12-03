app.component('evaluation-card', {
    template: $TEMPLATES['evaluation-card'],

    props: {
        entity: {
            type: [Entity, Object],
            required: true,
        },
        buttonLabel: {
            type: String,
        },
    },

    setup(props, { slots }) {
        const hasSlot = name => !!slots[name];
        const text = Utils.getTexts('evaluation-card');
        return { text, hasSlot }
    },

    computed: {
        dateFrom() {
            console.log('Debug dateFrom:', this.entity);
            if (!this.entity || !this.entity.registrationFrom) {
                console.warn('registrationFrom is null or undefined');
                return null;
            }
            if (this.entity.registrationFrom instanceof McDate) {
                return this.entity.registrationFrom;
            } else {
                return new McDate(this.entity.registrationFrom.date);
            }
        },

        dateTo() {
            console.log('Debug dateTo:', this.entity);
            if (!this.entity || !this.entity.registrationTo) {
                console.warn('registrationTo is null or undefined');
                return null;
            }
            if (this.entity.registrationTo instanceof McDate) {
                return this.entity.registrationTo;
            } else {
                return new McDate(this.entity.registrationTo.date);
            }
        },
    },
});
