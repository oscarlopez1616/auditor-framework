# Nemuru environments: 
there are the following enviorenments:
```bash
prod
    prod
    prod_br_fix
demo
dev
```

# Nemuru API - Nemuru
Download the docker-web project and execute the next command

```bash
ansible-playbook playbook-setup-environment.yml --vault-password-file password.yml
```


Execute gradle with the gradle wrapper ./gradlew

# Rise up workers:
```bash
symfony rabbitmq:consumer -w sync_and_integration.basic_unit.crm
```
```bash
symfony rabbitmq:consumer -w sync_and_integration.basic_unit.ticketing
```
```bash
symfony rabbitmq:consumer -w sync_and_integration.basic_unit.borrower_emailing
```
```bash
symfony rabbitmq:consumer -w sync_and_integration.basic_unit.merchant_emailing
```
```bash
symfony rabbitmq:consumer -w sync_and_integration.basic_unit.lender_auditor_framework
```

# TaskRunners:
```bash
./bin/console auditor_framework:task_runner:activate_all_activable_loans_controller
```
```bash
./bin/console auditor_framework:task_runner:choose_selectable_loans
```
```bash
./bin/console auditor_framework:task_runner:sign_all_contracts_signed_in_bs
```
Up all of them and keep running every 30 seconds
```bash
./gradlew launchTaskRunners
```

# Rise up reactive Endpoint:
```bash
symfony auditor_framework:reactive:server:init 
```

# Test Api with newman:
```bash
newman run https://www.getpostman.com/collections/c356639813bb8d9c4e3a -e docker_web.postman_environment.json
```

# Run Projections:
Running this projection is only allowed Afterwards we have deleted all content of the readModel
```bash
symfony event-store:projection:run cam_landing_generator_affiliate_projection -o
```
```bash
symfony event-store:projection:run cam_landing_generator_cam_unit_projection -o
```

# Renqueue Message from sync_and_integration dead letter to source queue exchange:
```bash
./bin/console auditor_framework:basic-sync:dead_letter_reenqueue
```
# remove duplicates from sync_and_integration.dead_letter_queue queue, only based on eventId(warning wit this command):
```bash
./bin/console auditor_framework:basic-sync:dead_letter_remove_duplicate_messages
```

# remove message from sync_and_integration.dead_letter_queue queue, only based on eventId(warning wit this command):
```bash
./bin/console auditor_framework:basic-sync:dead_letter_remove_message_by_id 1234
```

# Renqueue Message from sync_and_integration dead letter to sync_and_integration exchange(warning wit this command):
```bash
./bin/console auditor_framework:basic-sync:dead_letter_reenqueue_fan_out
```


# Create Docker Image
```bash
docker build -t auditor_framework/imageTag etc/docker/php
docker tag auditor_framework/php-prod:imageTag auditor_framework/php-prod:imageTag
docker push auditor_framework/php-prod:imageTag

docker login --username auditor_framework
```
and example:
 
```bash
docker build -t auditor_framework/php-prod:7.3.7-fpm etc/docker/php
docker tag auditor_framework/php-prod:7.3.7-fpm auditor_framework/php-prod:7.3.7-fpm
docker push auditor_framework/php-prod:7.3.7-fpm

docker login --username auditor_framework
```

# Environments
```
Environment (Abstract parent environment from which all others must inherit with Unnax BankReader callbacks)
│
└───Prod (Dependency injection will load real services with prod variables with Unnax BankReader callbacks)
│
└───Integration (Dependency injection will load real services with integration variables with Unnax BankReader callbacks)
│   │   Dev (Dependency injection will load real services with integration variables without Unnax BankReader callbacks)
└───Demo (Dependency injection will load mocked services with Unnax BankReader callbacks)
```

# Kubernetes Dashboard

To access the Kubernetes Dashboard run:

```
kubectl -n kube-system describe secret $(kubectl -n kube-system get secret | grep admin-user | awk '{print $1}')
```

copy the value in the "token" key and then run:

```
kubectl proxy
```
Kubectl will make Dashboard available at http://localhost:8001/api/v1/namespaces/kubernetes-dashboard/services/ https:kubernetes-dashboard:/proxy/

Now paste the token into Enter token field on log in screen.

