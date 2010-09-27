<?php
/**
 * This class contains code related to generating and handling a mailbox
 * message list.  This class will keep track of the current index within
 * a mailbox.
 *
 * Copyright 2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * @author   Michael Slusarz <slusarz@horde.org>
 * @category Horde
 * @license  http://www.fsf.org/copyleft/gpl.html GPL
 * @package  IMP
 */
class IMP_Mailbox_List_Track extends IMP_Mailbox_List
{
    /**
     * The location in the sorted array we are at.
     *
     * @var integer
     */
    protected $_index = null;

    /**
     * The list of additional variables to serialize.
     *
     * @var array
     */
    protected $_slist = array('_index');

    /**
     * Returns the current message array index. If the array index has
     * run off the end of the message array, will return the last index.
     *
     * @return integer  The message array index.
     */
    public function getMessageIndex()
    {
        return $this->isValidIndex()
            ? ($this->_index + 1)
            : 1;
    }

    /**
     * Checks to see if the current index is valid.
     *
     * @return boolean  True if index is valid, false if not.
     */
    public function isValidIndex()
    {
        return !is_null($this->_index);
    }

    /**
     * Returns IMAP mbox/UID information on a message.
     *
     * @param integer $offset  The offset from the current message.
     *
     * @return array  Array with the following entries:
     * <pre>
     * 'mailbox' - (string) The mailbox.
     * 'uid' - (integer) The message UID.
     * </pre>
     */
    public function getIMAPIndex($offset = 0)
    {
        $index = $this->_index + $offset;

        return isset($this->_sorted[$index])
            ? array(
                  'mailbox' => ($this->_searchmbox ? $this->_sortedMbox[$index] : $this->_mailbox),
                  'uid' => $this->_sorted[$index]
              )
            : array();
    }

    /**
     * Using the preferences and the current mailbox, determines the messages
     * to view on the current page.
     *
     * @see parent::buildMailboxPage()
     */
    public function buildMailboxPage($page = 0, $start = 0, $opts = array())
    {
        $ret = parent::buildMailboxPage($page, $start, $opts);

        if (!$this->_searchmbox) {
            $ret['index'] = $this->_index;
        }

        return $ret;
    }

    /**
     * Updates the message array index.
     *
     * @param mixed $data  If an integer, the number of messages to increase
     *                     array index by. If an indices object, sets array
     *                     index to the index value.
     */
    public function setIndex($data)
    {
        if ($data instanceof IMP_Indices) {
            list($mailbox, $uid) = $data->getSingle();
            $this->_index = $this->getArrayIndex($uid, $mailbox);
            if (empty($this->_index)) {
                $this->_rebuild(true);
                $this->_index = $this->getArrayIndex($uid, $mailbox);
            }
        } elseif (!is_null($this->_index)) {
            $index = $this->_index += $data;
            if (isset($this->_sorted[$this->_index])) {
                $this->_rebuild();
            } else {
                $this->_rebuild(true);
                $this->_index = isset($this->_sorted[$index])
                    ? $index
                    : null;
            }
        }
    }

    /**
     * Determines if a rebuild is needed, and, if necessary, performs
     * the rebuild.
     *
     * @param boolean $force  Force a rebuild?
     */
    protected function _rebuild($force = false)
    {
        if ($force ||
            (!is_null($this->_index) && !$this->getIMAPIndex(1))) {
            $this->_sorted = null;
            $this->_buildMailbox();
        }
    }

    /**
     * Returns the current sorted array without the given messages.
     *
     * @param mixed $indices  An IMP_Indices object or true to remove all
     *                        messages in the mailbox.
     */
    public function removeMsgs($indices)
    {
        if (parent::removeMsgs($indices)) {
            /* Update the current array index to its new position in the
             * message array. */
            $this->setIndex(0);
        }
    }

}
