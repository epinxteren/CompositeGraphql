#!/bin/bash

# copy from https://gist.github.com/irazasyed/a7b0a079e7727a4315b9

# PATH TO YOUR HOSTS FILE
ETC_HOSTS=/etc/hosts

# DEFAULT IP FOR HOSTNAME
IP="127.0.0.1"

# TODO: Can we not hardcode these?
HOSTNAMES=("graphql" "traefik")
HOSTNAMES_SHORT=("redis" "elasticsearch" "database")

removehost() {
    if [ -n "$(grep $HOSTNAME /etc/hosts)" ]
    then
        echo "$HOSTNAME Found in your $ETC_HOSTS, Removing now...";
        sudo sed -i".bak" "/$HOSTNAME/d" $ETC_HOSTS
    else
        echo "$HOSTNAME was not found in your $ETC_HOSTS";
    fi
}

addhost() {
    HOSTS_LINE="$IP\t$HOSTNAME"
    if [ -n "$(grep $HOSTNAME /etc/hosts)" ]
        then
            echo -e "$(grep $HOSTNAME $ETC_HOSTS) # already exists"
        else
            echo "Adding $HOSTNAME to your $ETC_HOSTS";
            sudo -- sh -c -e "echo '$HOSTS_LINE' >> /etc/hosts";

            if [ -n "$(grep $HOSTNAME /etc/hosts)" ]
                then
                    echo "$HOSTNAME was added succesfully \n $(grep $HOSTNAME /etc/hosts)";
                else
                    echo "Failed to Add $HOSTNAME, Try again!";
            fi
    fi
}


for HOSTNAME in "${HOSTNAMES[@]}"
do
   HOSTNAME=("${HOSTNAME}.${COMPOSE_PROJECT_NAME}.local")
   $@
done


for HOSTNAME in "${HOSTNAMES_SHORT[@]}"
do
   $@
done

