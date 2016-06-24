# log-prototype

Set up docker with `sh setup.sh`.

Set up hosts with `sudo sh sudo-hosts.sh`.

Verify you can reach the web app by going to http://log-prototype:8109 in the browser.

## Architecture

Monolog php component logging records to elasticsearch.

We have a Kibana dashboard for internal developer use only.
Go to http://log-prototype:5601 and enter `audit-log-*` for the index pattern.

#### To Do

 - View entire audit log for the past X days
 - View my audit log for the past X days
 - Export audit logs older than X days and delete from elasticsearch (for upload to S3/Glacier - see https://github.com/taskrabbit/elasticsearch-dump)