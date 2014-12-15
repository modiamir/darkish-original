<?php

namespace Proxies\__CG__\Darkish\CategoryBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class ManagedFile extends \Darkish\CategoryBundle\Entity\ManagedFile implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'file', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'id', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'userId', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'fileName', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'path', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'filemime', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'filesize', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'status', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'timestamp', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'type', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'entityId', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'uploadDir', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'uploadKey');
        }

        return array('__isInitialized__', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'file', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'id', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'userId', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'fileName', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'path', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'filemime', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'filesize', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'status', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'timestamp', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'type', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'entityId', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'uploadDir', '' . "\0" . 'Darkish\\CategoryBundle\\Entity\\ManagedFile' . "\0" . 'uploadKey');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (ManagedFile $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFile', array($file));

        return parent::setFile($file);
    }

    /**
     * {@inheritDoc}
     */
    public function getFile()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFile', array());

        return parent::getFile();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setUserId($userId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUserId', array($userId));

        return parent::setUserId($userId);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUserId', array());

        return parent::getUserId();
    }

    /**
     * {@inheritDoc}
     */
    public function setFileName($fileName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFileName', array($fileName));

        return parent::setFileName($fileName);
    }

    /**
     * {@inheritDoc}
     */
    public function getFileName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFileName', array());

        return parent::getFileName();
    }

    /**
     * {@inheritDoc}
     */
    public function setPath($path)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPath', array($path));

        return parent::setPath($path);
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPath', array());

        return parent::getPath();
    }

    /**
     * {@inheritDoc}
     */
    public function setFilemime($filemime)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFilemime', array($filemime));

        return parent::setFilemime($filemime);
    }

    /**
     * {@inheritDoc}
     */
    public function getFilemime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFilemime', array());

        return parent::getFilemime();
    }

    /**
     * {@inheritDoc}
     */
    public function setFilesize($filesize)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFilesize', array($filesize));

        return parent::setFilesize($filesize);
    }

    /**
     * {@inheritDoc}
     */
    public function getFilesize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFilesize', array());

        return parent::getFilesize();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($status));

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', array());

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setTimestamp($timestamp)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTimestamp', array($timestamp));

        return parent::setTimestamp($timestamp);
    }

    /**
     * {@inheritDoc}
     */
    public function getTimestamp()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTimestamp', array());

        return parent::getTimestamp();
    }

    /**
     * {@inheritDoc}
     */
    public function setType($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setType', array($type));

        return parent::setType($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getType', array());

        return parent::getType();
    }

    /**
     * {@inheritDoc}
     */
    public function setEntityId($entityId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEntityId', array($entityId));

        return parent::setEntityId($entityId);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEntityId', array());

        return parent::getEntityId();
    }

    /**
     * {@inheritDoc}
     */
    public function getAbsolutePath()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAbsolutePath', array());

        return parent::getAbsolutePath();
    }

    /**
     * {@inheritDoc}
     */
    public function getWebPath()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWebPath', array());

        return parent::getWebPath();
    }

    /**
     * {@inheritDoc}
     */
    public function setUploadDir($uploadDir)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUploadDir', array($uploadDir));

        return parent::setUploadDir($uploadDir);
    }

    /**
     * {@inheritDoc}
     */
    public function setUploadKey($uploadKey)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUploadKey', array($uploadKey));

        return parent::setUploadKey($uploadKey);
    }

    /**
     * {@inheritDoc}
     */
    public function fileValidation(\Symfony\Component\Validator\Context\ExecutionContextInterface $context)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'fileValidation', array($context));

        return parent::fileValidation($context);
    }

    /**
     * {@inheritDoc}
     */
    public function upload()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'upload', array());

        return parent::upload();
    }

}
