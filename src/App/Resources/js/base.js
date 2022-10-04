import moment from "moment-timezone";
import phpunserialize from "phpunserialize";

export default {
    methods: {
        jobBaseName(name) {
            if (!name.includes('\\')) return name;

            let parts = name.split('\\');

            return parts[parts.length - 1];
        },

        formatDate(unixTime) {
            return moment(unixTime * 1000).add(new Date().getTimezoneOffset() / 60);
        },

        readableTimestamp(timestamp) {
            return this.formatDate(timestamp).format('YYYY-MM-DD HH:mm:ss');
        },

        prettyPrintJob(data) {
            try {
                return data.command && !data.command.includes('CallQueuedClosure')
                    ? phpunserialize(data.command) : data;
            } catch (err) {
                return data;
            }
        }
    }
}
