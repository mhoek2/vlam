Updating
========

Updating (cloned version only)
------------------------------

.. tip::
	- Assuming you followed deployment key setup in :ref:`Cloning <cloning-guide>`
	- Replace 'repo-user' in the following snippets with the repo owner username

#. Create a update.sh file
    .. code-block:: bash

        # cd to your root application instance path. (NOT server root like clone.sh)
        cd /var/www/html/vlam
        sudo nano update.sh

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

        # Update the repo
        git pull git@vlam:repo-user/vlam.git

        # 1b. make update.sh executable
        sudo chmod +x update.sh

#. Run update.sh
    .. code-block:: bash

        ./update.sh
