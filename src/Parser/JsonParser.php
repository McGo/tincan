<?php

/**
 *
 * @author khoa <khoa@go1.com.au>
 */

namespace GO1\LMS\TinCan\Parser;

use GO1\LMS\TinCan\TinCanAPI;
use GO1\LMS\TinCan\TinCanFactoryInterface;

class JsonParser implements JsonParserInterface {

  /**
   *
   * @var TinCanFactoryInterface 
   */
  protected $factory;

  /**
   * 
   * @param TinCanFactoryInterface $factory
   */
  public function __construct(TinCanFactoryInterface $factory) {
    $this->factory = $factory;
  }

  /**
   * {@inheritdoc}
   */
  public function parse($json) {
    $jsonObject = json_decode($json);
    if (isset($jsonObject->statements)) {
      $jsonObject->statements = $this->parseStatements($jsonObject->statements);
    }
    return $jsonObject;
  }

  /**
   * @{inheritdoc}
   */
  public function parseStatements($statements) {
    $statementsArray = array();
    foreach ($statements as $statementJsonObject) {
      $statement = $this->parseStatement($statementJsonObject);
      if (!is_null($statement)) {
        $statementsArray[] = $statement;
      }
    }
    return $statementsArray;
  }

  /**
   * @{inheritdoc}
   */
  public function parseStatement($statementJsonObject) {
    if (isset($statementJsonObject->actor) &&
        isset($statementJsonObject->verb) &&
        isset($statementJsonObject->object)) {

      $actor = $this->parseActor($statementJsonObject->actor);
      $verb = $this->parseVerb($statementJsonObject->verb);
      $object = $this->parseObject($statementJsonObject->object);

      if (!is_null($actor) && !is_null($verb) && !is_null($object)) {
        $statement = $this->factory->createStatement($actor, $verb, $object);

        if (isset($statementJsonObject->id)) {
          $statement->setId($statementJsonObject->id);
        }

        if (isset($statementJsonObject->result)) {
          $result = $this->parseResult($statementJsonObject->result);
          $statement->setResult($result);
        }

        if (isset($statementJsonObject->context)) {
          $context = $this->parseContext($statementJsonObject->context);
          $statement->setContext($context);
        }

        if (isset($statementJsonObject->timestamp)) {
          $statement->setTimestamp($statementJsonObject->timestamp);
        }

        if (isset($statementJsonObject->stored)) {
          $statement->setStored($statementJsonObject->stored);
        }

        if (isset($statementJsonObject->authority)) {
          $authority = $this->parseActor($statementJsonObject->authority);
          $statement->setAuthority($authority);
        }

        if (isset($statementJsonObject->version)) {
          $statement->setVersion($statementJsonObject->version);
        }

        if (isset($statementJsonObject->attachments)) {
          $attachments = $this->parseAttachments($statementJsonObject->attachments);
          $statement->setAttachments($attachments);
        }

        return $statement;
      }
    }
  }

  /**
   * @{inheritdoc}
   */
  public function parseActor($actorJsonObject) {
    if (isset($actorJsonObject->account)) {
      $actorJsonObject->account = (array) $actorJsonObject->account;
    }

    $id = $this->parseInverseIdentity($actorJsonObject);

    $name = isset($actorJsonObject->name) ? $actorJsonObject->name : NULL;

    $members = isset($actorJsonObject->member) ? $this->parseMembers($actorJsonObject->member) : NULL;

    $objectType = isset($actorJsonObject->objectType) ? $actorJsonObject->objectType : NULL;

    return $this->factory->createActor($objectType, $id, $name, $members);
  }

  /**
   * @{inheritdoc}
   */
  public function parseInverseIdentity($jsonObject) {
    foreach (TinCanAPI::$inverseIdentityTypes as $type) {
      if (isset($jsonObject->$type)) {
        return $this->factory->createInverseIdentity($type, $jsonObject->$type);
      }
    }
    return NULL;
  }

  /**
   * 
   * @param array $members
   */
  public function parseMembers($members) {
    $membersArray = array();
    foreach ($members as $agentJsonObject) {
      $membersArray[] = $this->parseActor($agentJsonObject);
    }
    return $membersArray;
  }

  /**
   * @{inheritdoc}
   */
  public function parseVerb($jsonObject) {
    if (isset($jsonObject->id)) {
      $verb = $this->factory->createVerb($jsonObject->id);
      if (isset($jsonObject->display)) {
        $verb->setDisplay($this->parseLanguageMap($jsonObject->display));
      }
      return $verb;
    }
    return NULL;
  }

  /**
   * @{inheritdoc}
   */
  public function parseObject($jsonObject) {
    $type = isset($jsonObject->objectType) ? $jsonObject->objectType : NULL;

    // try parsing inverse identity
    $id = isset($jsonObject->id) ? $jsonObject->id : $this->parseInverseIdentity($jsonObject);

    $name = isset($jsonObject->name) ? $jsonObject->name : NULL;

    $members = isset($jsonObject->members) ? $this->parseMembers($jsonObject->members) : NULL;

    $statement = NULL;
    if (isset($jsonObject->objectType) &&
        ($jsonObject->objectType == 'SubStatement' ||
        $jsonObject->objectType == 'StatementRef')) {
      $statement = $this->parseStatement($jsonObject);
    }

    $object = $this->factory->createObject($type, $id, $name, $members, $statement);

    if (!is_null($object)) {
      $this->parseIntoActivity($object, $jsonObject);
    }

    // @todo Agent, Group, SubStatement, StatementRef

    return $object;
  }

  protected function parseIntoActivity($activity, $jsonObject) {
    if (isset($jsonObject->definition)) {
      $definition = $this->parseActivityDefinition($jsonObject->definition);
      $activity->setDefinition($definition);
    }
  }

  protected function parseActivityDefinition($jsonObject) {
    $definition = $this->factory->createActivityDefinition();
    if (isset($jsonObject->name)) {
      $definition->setName($this->parseLanguageMap($jsonObject->name));
    }
    if (isset($jsonObject->description)) {
      $definition->setDescription($this->parseLanguageMap($jsonObject->description));
    }
    if (isset($jsonObject->type)) {
      $definition->setType($jsonObject->type);
    }
    if (isset($jsonObject->moreInfo)) {
      $definition->setMoreInfo($jsonObject->moreInfo);
    }

    if (isset($jsonObject->interactionType)) {
      $definition->setInteractionType($jsonObject->interactionType);
    }

    // @todo double check terminology of `component list`
    foreach (TinCanAPI::$componentLists as $list) {
      if (isset($jsonObject->$list)) {
        $interactionsArray = array();
        foreach ($jsonObject->$list as $interactionJsonObject) {
          $interactionsArray[] = $this->parseInteractionComponent($interactionJsonObject);
        }
        $definition->setComponents($list, $interactionsArray, $jsonObject->interactionType);
      }
    }

    if (isset($jsonObject->correctResponsePatterns)) {
      $definition->setCorrectResponsePatterns((array) $jsonObject->correctResponsePatterns);
    }

    return $definition;
  }

  /**
   * 
   * @param stdClasd $jsonObject
   * @return InteractionComponent
   */
  protected function parseInteractionComponent($jsonObject) {
    if (isset($jsonObject->id)) {
      $interaction = $this->factory->createInteractionComponent($jsonObject->id);
      if (isset($jsonObject->description)) {
        $interaction->setDescription($this->parseLanguageMap($jsonObject->description));
      }
      return $interaction;
    }
    return NULL;
  }

  /**
   * @{inheritdoc}
   */
  public function parseLanguageMap($jsonObject) {
    return $this->factory->createLanguageMap($jsonObject);
  }

  /**
   * @{inheritdoc}
   */
  public function parseResult($jsonObject) {
    $result = $this->factory->createResult();
    if (isset($jsonObject->score)) {
      $score = $this->parseScore($jsonObject->score);
      $result->setScore($score);
    }
    if (isset($jsonObject->success)) {
      $result->setSuccess($jsonObject->success);
    }
    if (isset($jsonObject->completion)) {
      $result->setCompletion($jsonObject->completion);
    }
    if (isset($jsonObject->response)) {
      $result->setResponse($jsonObject->response);
    }
    if (isset($jsonObject->duration)) {
      $result->setDuration($jsonObject->duration);
    }
    return $result;
  }

  /**
   * 
   */
  public function parseScore($jsonObject) {
    $score = $this->factory->createScore();
    if (isset($jsonObject->scaled)) {
      $score->setScaled($jsonObject->scaled);
    }
    if (isset($jsonObject->min)) {
      $score->setMin($jsonObject->min);
    }
    if (isset($jsonObject->max)) {
      $score->setMax($jsonObject->max);
    }
    if (isset($jsonObject->raw)) {
      $score->setRaw($jsonObject->raw);
    }
    return $score;
  }

  /**
   * @{inheritdoc}
   */
  public function parseContext($jsonObject) {
    $context = $this->factory->createContext();
    if (isset($jsonObject->registration)) {
      $context->setRegistration($jsonObject->registration);
    }
    if (isset($jsonObject->instructor)) {
      $context->setInstructor($this->parseActor($jsonObject->instructor));
    }
    if (isset($jsonObject->team)) {
      $context->setTeam($this->parseActor($jsonObject->team));
    }

    if (isset($jsonObject->contextActivities)) {
      $contextActivities = $this->parseContextActivities($jsonObject->contextActivities);
      $context->setContextActivities($contextActivities);
    }

    if (isset($jsonObject->revision)) {
      $context->setRevision($jsonObject->revision);
    }

    if (isset($jsonObject->platform)) {
      $context->setPlatform($jsonObject->platform);
    }

    if (isset($jsonObject->language)) {
      $context->setLanguage($jsonObject->language);
    }

    if (isset($jsonObject->statement)) {
      // StatementRef
      $context->setStatement($this->parseStatement($jsonObject->statement));
    }

    if (isset($jsonObject->extensions)) {
      $extensions = $this->parseExtensions($jsonObject->extensions);
      $context->setExtensions($extensions);
    }

    return $context;
  }

  /**
   * 
   * @param stdClass $jsonObject
   */
  public function parseContextActivities($jsonObject) {
    $activitiesArray = array();
    foreach (TinCanAPI::$contextActivityKeys as $key) {
      if (isset($jsonObject->$key)) {
        foreach ($jsonObject->$key as $activity) {
          $activitiesArray[$key][] = $this->parseObject($activity);
        }
      }
    }
    return $activitiesArray;
  }

  /**
   * @{inheritdoc}
   */
  public function parseExtensions($extensions) {
    $extensionsArray = array();
    foreach ($extensions as $key => $value) {
      $extensionsArray[] = $this->factory->createExtension($key, $value);
    }
    return $extensionsArray;
  }

  /**
   * @{inheritdoc}
   */
  public function parseAttachments($attachments) {
    $attachmentsArray = array();
    foreach ($attachments as $attachmentJsonObject) {
      $attachmentsArray[] = $this->parseAttachment($attachmentJsonObject);
    }
    return $attachmentsArray;
  }

  /**
   * 
   * @param stdClass $attachmentJsonObject
   * @return Attachment
   */
  public function parseAttachment($attachmentJsonObject) {
    $attachment = $this->factory->createAttachment(
        $attachmentJsonObject->usageType, $attachmentJsonObject->display, $attachmentJsonObject->contentType, $attachmentJsonObject->length, $attachmentJsonObject->sha2
    );
    if (isset($attachmentJsonObject->description)) {
      $description = $this->parseLanguageMap($attachmentJsonObject->description);
      $attachment->setDescription($description);
    }
    if (isset($attachmentJsonObject->fileUrl)) {
      $attachment->setFileUrl($attachmentJsonObject->fileUrl);
    }
    return $attachment;
  }

}
