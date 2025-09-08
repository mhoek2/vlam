.. _cloning-guide:

Cloning
=======

Cloning (private repo only)
------------------------------

When the repository is private, a deployment key is required

.. tip::
	Replace 'repo-user' in the following snippets with the repo owner username

#. Create a public key using ssh-keygen
    .. code-block:: bash

        # Create a ssh pub key
        cd ~/.ssh/
        ssh-keygen -t rsa -b 4096 -C "vlam-deploy"

        # Add to ssh config
        nano ~/.ssh/config:

        Host vlam
          HostName github.com
          User repo-user
          IdentityFile ~/.ssh/vlam-deploy

        # Test authentication
        ssh -T git@vlam

#. Go to GitHub.com and navigate to: **Your repository -> Settings -> Deploy keys**
#. Click **Add a deploy key** and keep it read-only!
#. Enter a name, then copy the content of the .pub file in the value field.
    .. code-block:: bash

        # find the content of the .pub key:
        cat ~/.ssh/vlam-deploy.pub


#. Create a clone.sh file
    .. code-block:: bash

        # cd to your root webserver path.
        cd /var/www/html
        sudo nano clone.sh

        # 1a. enter the following content:

        #!/bin/bash
        #

        # Check if ssh-agent is running
        if ! pgrep -u "$USER" ssh-agent > /dev/null; then
            echo "Starting ssh-agent..."
            eval "$(ssh-agent -s)"
        else
            echo "ssh-agent already running."
        fi

        # Check if the key is already added
        if ! ssh-add -l | grep -q "$(ssh-keygen -lf ~/.ssh/vlam-deploy | awk '{print $2}')"; then
            echo "Adding SSH key..."
            ssh-add ~/.ssh/vlam-deploy
        else
            echo "SSH key already added."
        fi

        # Clone the repo
        git clone git@vlam:repo-user/vlam.git

        # 1b. make clone.sh executable
        sudo chmod +x clone.sh

#. Run clone.sh
    .. code-block:: bash

        ./clone.sh
