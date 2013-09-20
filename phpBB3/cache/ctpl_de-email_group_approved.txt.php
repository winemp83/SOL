<?php if (!defined('IN_PHPBB')) exit; ?>Subject: Dein Mitgliedsantrag wurde bestätigt

Herzlichen Glückwunsch,

dein Antrag auf Mitgliedschaft in der Benutzergruppe „<?php echo (isset($this->_rootref['GROUP_NAME'])) ? $this->_rootref['GROUP_NAME'] : ''; ?>“ auf „<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>“ wurde bestätigt.
Besuche folgenden Link, um deine Mitgliedschaft anzuzeigen:

<?php echo (isset($this->_rootref['U_GROUP'])) ? $this->_rootref['U_GROUP'] : ''; ?>


<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>