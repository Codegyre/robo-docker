<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    public function release()
    {
        $version = file_get_contents('VERSION');
        // ask for changes in this release
        $changelog = $this->taskChangelog()
            ->version($version)
            ->askForChanges()
            ->run();

        // adding changelog and pushing it
        $this->taskGitStack()
            ->add('CHANGELOG.md')
            ->commit('updated changelog')
            ->push()
            ->run();

        // create GitHub release
        $this->taskGitHubRelease($version)
            ->uri('Codegyre/robo-docker')
            ->askDescription()
            ->run();
    }

}